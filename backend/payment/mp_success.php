<?php
// Mercado Pago Checkout Pro success back_url.
// Trust model: no IPN webhook in local dev, so the payment is re-verified
// server-side against the MP API before any order row is marked as paid.
session_start();

$ref = isset($_GET['ref']) ? (string)$_GET['ref'] : '';
if (!preg_match('/^u(\d+)-\d+$/', $ref, $matches)) {
    header('Location: /pages/checkout/order.php?mp=unverified');
    exit;
}
$refUser = (int)$matches[1];

// The reference must belong to the user coming back.
if (!isset($_SESSION['code_user'])) {
    header('Location: /pages/auth/signin.php');
    exit;
}
if ((int)$_SESSION['code_user'] !== $refUser) {
    header('Location: /pages/checkout/order.php?mp=unverified');
    exit;
}

// Config missing or empty token: honestly cannot verify -> no state change.
$configPath = __DIR__ . '/../_payment_config.php';
$config = is_file($configPath) ? require $configPath : array();
$accessToken = is_array($config) && isset($config['access_token'])
    ? trim((string)$config['access_token']) : '';
if ($accessToken === '') {
    header('Location: /pages/checkout/order.php?mp=unverified');
    exit;
}

// Server-side verification of the payment for this external_reference.
$searchUrl = 'https://api.mercadopago.com/v1/payments/search?external_reference='
    . urlencode($ref) . '&limit=1';
$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL            => $searchUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => array('Authorization: Bearer ' . $accessToken),
    CURLOPT_TIMEOUT        => 10,
));
$responseBody = curl_exec($ch);
$httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$paid = false;
if ($responseBody !== false && $httpCode >= 200 && $httpCode < 300) {
    $decoded = json_decode($responseBody, true);
    $status = is_array($decoded) && isset($decoded['results'][0]['status'])
        ? (string)$decoded['results'][0]['status'] : '';
    $paid = in_array($status, array('approved', 'authorized'), true);
}
if (!$paid) {
    // Empty results, rejected/cancelled/in_process, or API failure.
    header('Location: /pages/checkout/order.php?mp=unverified');
    exit;
}

// PAID: copy the profile delivery data onto this user's cart rows.
include __DIR__ . '/../_conection.php';
$address = '';
$phone = '';
$sql = 'SELECT address_user, city_user, region_user, zip_user, country_user, phone_user
        FROM users WHERE code_user=?';
$stmt = mysqli_prepare($con, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'i', $refUser);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_array($result)) {
        $addressParts = array();
        $fields = array('address_user', 'city_user', 'region_user', 'zip_user', 'country_user');
        foreach ($fields as $field) {
            $value = isset($row[$field]) ? trim((string)$row[$field]) : '';
            if ($value !== '') {
                $addressParts[] = $value;
            }
        }
        $address = implode(', ', $addressParts);
        $phone = isset($row['phone_user']) ? (string)$row['phone_user'] : '';
    }
    mysqli_stmt_close($stmt);
}

// Idempotent: 0 rows affected (e.g. a refresh) still redirects as success.
$update = 'UPDATE orders SET state_order=3, address_order=?, phone_order=?
           WHERE code_user=? AND state_order=1';
$stmt = mysqli_prepare($con, $update);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'ssi', $address, $phone, $refUser);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
mysqli_close($con);

header('Location: /pages/checkout/order.php?mp=success');
exit;
