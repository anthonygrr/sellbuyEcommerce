<?php
// Mercado Pago configuration loader (no secrets in this file).
// Real credentials live in the project-root .env (gitignored), keys:
//   MP_ACCESS_TOKEN, MP_CURRENCY_ID, MP_BASE_URL
// Template for the keys: backend/_payment_config.sample.php
$envPath = dirname(__DIR__) . '/.env';
$env = array();
if (is_readable($envPath)) {
    foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) {
            continue;
        }
        $key = trim(substr($line, 0, strpos($line, '=')));
        $value = trim(substr($line, strpos($line, '=') + 1));
        // Strip optional surrounding quotes (single or double).
        $len = strlen($value);
        if ($len >= 2 && ($value[0] === '"' || $value[0] === "'") && $value[$len - 1] === $value[0]) {
            $value = substr($value, 1, -1);
        }
        $env[$key] = $value;
    }
}

return array(
    'access_token' => isset($env['MP_ACCESS_TOKEN']) ? $env['MP_ACCESS_TOKEN'] : '',
    'currency_id'  => (isset($env['MP_CURRENCY_ID']) && $env['MP_CURRENCY_ID'] !== '')
        ? $env['MP_CURRENCY_ID'] : 'MXN',
    'base_url'     => isset($env['MP_BASE_URL']) ? $env['MP_BASE_URL'] : '',
);
