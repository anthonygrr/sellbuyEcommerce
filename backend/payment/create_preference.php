<?php
// Mercado Pago Checkout Pro (redirect flow).
// Creates a payment preference for the logged user's cart via plain REST
// (curl, no SDK) and returns the hosted checkout URL (init_point).
session_start();
header('Content-Type: application/json');

// Session gate: not logged in.
if (!isset($_SESSION['code_user'])) {
    echo json_encode(array('state' => false, 'detail' => 'You are not logged', 'open_login' => true));
    exit;
}

// Config gate: no credentials yet -> honest, friendly message (no MP call).
$configPath = __DIR__ . '/../_payment_config.php';
$config = is_file($configPath) ? require $configPath : array();
$accessToken = is_array($config) && isset($config['access_token'])
    ? trim((string)$config['access_token']) : '';
if ($accessToken === '') {
    echo json_encode(array('state' => false,
        'detail' => 'Mercado Pago is not configured: fill MP_ACCESS_TOKEN in the .env file at the project root'));
    exit;
}
$currencyId = is_array($config) && isset($config['currency_id']) ? trim((string)$config['currency_id']) : '';
if ($currencyId === '') {
    $currencyId = 'MXN';
}

include __DIR__ . '/../_conection.php';
$code_user = (int)$_SESSION['code_user'];

// The logged user's pending cart rows, grouped per product.
$sql = "SELECT ord.code_prod, COUNT(*) AS qty, p.name_prod, p.price_prod
        FROM orders ord
        INNER JOIN products p ON ord.code_prod = p.code_prod
        WHERE ord.code_user = ? AND ord.state_order = 1
        GROUP BY ord.code_prod, p.name_prod, p.price_prod";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, 'i', $code_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// name_prod is stored as UTF-8 by the connection; only re-encode if a value
// arrives as latin1 bytes so the JSON sent to MP is always valid UTF-8.
function mp_utf8($value) {
    $value = (string)$value;
    if (mb_check_encoding($value, 'UTF-8')) {
        return $value;
    }
    return mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
}

$items = array();
while ($row = mysqli_fetch_array($result)) {
    $items[] = array(
        'title'       => mp_utf8($row['name_prod']),
        'quantity'    => (int)$row['qty'],
        'unit_price'  => (float)$row['price_prod'],
        'currency_id' => $currencyId,
    );
}
mysqli_close($con);

if (!$items) {
    echo json_encode(array('state' => false, 'detail' => 'Your cart is empty'));
    exit;
}

// back_urls base: config value wins, otherwise detect scheme + host.
$baseUrl = is_array($config) && isset($config['base_url']) ? trim((string)$config['base_url']) : '';
if ($baseUrl === '') {
    $https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== ''
        && strtolower($_SERVER['HTTPS']) !== 'off';
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
    if (!preg_match('/^[A-Za-z0-9.\-:\[\]]+$/', $host)) {
        $host = 'localhost';
    }
    $baseUrl = ($https ? 'https' : 'http') . '://' . $host;
}
$baseUrl = rtrim($baseUrl, '/');

// Regex-parseable later by mp_success.php: "u{code_user}-{timestamp}".
$external_reference = 'u' . $code_user . '-' . time();

$payload = array(
    'items' => $items,
    'external_reference' => $external_reference,
    'back_urls' => array(
        'success' => $baseUrl . '/backend/payment/mp_success.php?ref=' . urlencode($external_reference),
        'cancel'  => $baseUrl . '/pages/checkout/order.php?mp=cancel',
        'pending' => $baseUrl . '/pages/checkout/order.php?mp=pending',
    ),
);

// Mercado Pago rejects auto_return together with http:// back_urls
// ("auto_return invalid. back_url.success must be defined"), and https-only
// auto-redirecting to a plain-http dev server would fail anyway. Send
// auto_return only for https bases; on http the MP page shows its own
// "Return to site" button pointing at the same success URL.
if (stripos($baseUrl, 'https://') === 0) {
    $payload['auto_return'] = 'approved';
}

$jsonBody = json_encode($payload);
if ($jsonBody === false) {
    echo json_encode(array('state' => false, 'detail' => 'Could not encode the cart for Mercado Pago'));
    exit;
}

$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL            => 'https://api.mercadopago.com/checkout/preferences',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_HTTPHEADER     => array(
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json',
    ),
    CURLOPT_POSTFIELDS     => $jsonBody,
    CURLOPT_TIMEOUT        => 10,
));
$responseBody = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($responseBody === false) {
    echo json_encode(array('state' => false, 'detail' => 'Mercado Pago request failed: ' . $curlError));
    exit;
}
$decoded = json_decode($responseBody, true);

if ($httpCode < 200 || $httpCode >= 300) {
    $message = '';
    if (is_array($decoded)) {
        if (isset($decoded['message']) && is_string($decoded['message'])) {
            $message = $decoded['message'];
        } elseif (isset($decoded['error']) && is_string($decoded['error'])) {
            $message = $decoded['error'];
        }
    }
    if ($message === '') {
        $message = 'Mercado Pago returned HTTP ' . $httpCode;
    }
    echo json_encode(array('state' => false, 'detail' => $message));
    exit;
}

$initPoint = is_array($decoded) && isset($decoded['init_point']) ? (string)$decoded['init_point'] : '';
if ($initPoint === '') {
    echo json_encode(array('state' => false, 'detail' => 'Mercado Pago did not return a payment link'));
    exit;
}

echo json_encode(array('state' => true, 'init_point' => $initPoint));
exit;
