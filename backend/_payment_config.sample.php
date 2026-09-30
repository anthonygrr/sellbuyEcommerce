<?php
// Mercado Pago configuration keys.
// Real values go in the project-root .env file (gitignored), which
// backend/_payment_config.php loads:
//   MP_ACCESS_TOKEN=TEST-... or APP_USR-...
//   MP_CURRENCY_ID=MXN
//   MP_BASE_URL= (optional, e.g. http://localhost:3000)
// https://www.mercadopago.com.mx/developers/panel/app  -> Credenciales de prueba
return [
    'access_token' => '', // mirror of MP_ACCESS_TOKEN
    'currency_id'  => 'MXN', // mirror of MP_CURRENCY_ID
    'base_url'     => '', // mirror of MP_BASE_URL — auto-detected when empty
];
