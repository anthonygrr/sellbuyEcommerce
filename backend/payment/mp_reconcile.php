<?php
// Mercado Pago lazy reconciliation helper (include-once, no output, no HTML).
// Self-healing counterpart of mp_success.php: when the Checkout Pro return
// trip is lost (DNS flake, closed tab, no auto_return on http) the session
// keeps a pending ref and order.php/cart.php re-verify it on the next visit.
// Trust model is unchanged: the MP API is the source of truth server-side.

// Ref format: u{code_user}-{unix_ts}, created by create_preference.php.
function mp_ref_matches_user($ref, $code_user) {
    if (!preg_match('/^u(\d+)-(\d+)$/', (string)$ref, $matches)) {
        return false;
    }
    return (int)$matches[1] === (int)$code_user;
}

// Freshness bound: the ref carries the moment the preference was created, so
// an old ref is never re-checked (and never re-charged against the API).
function mp_ref_is_fresh($ref, $maxAge = 1800) {
    if (!preg_match('/^u(\d+)-(\d+)$/', (string)$ref, $matches)) {
        return false;
    }
    $age = time() - (int)$matches[2];
    return $age >= 0 && $age <= (int)$maxAge;
}

// Verifies the payment for this external_reference against the MP API and,
// when one is approved/authorized, marks the user's cart rows as paid.
// Idempotent: rows already at state 3 make the UPDATE affect 0 rows and the
// function still returns true. Returns true only when a paid payment exists.
function mp_reconcile_mark_paid($ref) {
    $ref = (string)$ref;
    if (!preg_match('/^u(\d+)-(\d+)$/', $ref, $refParts)) {
        return false;
    }
    $refUser = (int)$refParts[1];
    $ts = (int)$refParts[2];

    // Config missing or empty token: honestly cannot verify -> no state change.
    $configPath = __DIR__ . '/../_payment_config.php';
    $config = is_file($configPath) ? require $configPath : array();
    $accessToken = is_array($config) && isset($config['access_token'])
        ? trim((string)$config['access_token']) : '';
    if ($accessToken === '') {
        return false;
    }

    // Server-side verification of the payment for this external_reference.
    // A reference can hold several attempts (a rejected one followed by the
    // approved retry), so fetch them all and accept if ANY is paid.
    $searchUrl = 'https://api.mercadopago.com/v1/payments/search?external_reference='
        . urlencode($ref) . '&limit=20';

    // Retry loop: MP indexing right after the return can lag a few hundred ms
    // and the network can flake. Retry only on transport failure, HTTP >= 500
    // or an empty results array; stop as soon as results are non-empty (no
    // payment will appear later from the same search).
    $results = array();
    $attempts = 3;
    for ($attempt = 1; $attempt <= $attempts; $attempt++) {
        if ($attempt > 1) {
            usleep(400000);
        }

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

        $results = array();
        if ($responseBody !== false && $httpCode >= 200 && $httpCode < 300) {
            $decoded = json_decode($responseBody, true);
            if (is_array($decoded) && isset($decoded['results']) && is_array($decoded['results'])) {
                $results = $decoded['results'];
            }
        }

        if ($results) {
            break;
        }
        // Still empty (transport failure, HTTP >= 500, or indexing delay):
        // retry while the attempt budget lasts.
    }

    // Not paid (empty results, rejected/cancelled/in_process, API failure):
    // no DB access at all.
    $paid = false;
    foreach ($results as $payment) {
        $status = is_array($payment) && isset($payment['status'])
            ? (string)$payment['status'] : '';
        if (in_array($status, array('approved', 'authorized'), true)) {
            $paid = true;
            break;
        }
    }
    if (!$paid) {
        return false;
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

    // Idempotent: 0 rows affected (e.g. a refresh) still returns true.
    // The date_order <= guard skips rows the user added AFTER paying, so a
    // later cart addition is never marked paid by an older reference.
    // Timezone assumption: the DB session timezone is UTC (verified: session
    // time_zone is SYSTEM and NOW() equals UTC_TIMESTAMP(), and FROM_UNIXTIME
    // interprets the ref's unix ts in that same session timezone).
    $update = 'UPDATE orders SET state_order=3, address_order=?, phone_order=?
               WHERE code_user=? AND state_order=1 AND date_order <= FROM_UNIXTIME(?)';
    $stmt = mysqli_prepare($con, $update);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssii', $address, $phone, $refUser, $ts);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($con);

    return true;
}
