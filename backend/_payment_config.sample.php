<?php
// Mercado Pago configuration.
// Copy from _payment_config.sample.php and fill in your credentials:
// https://www.mercadopago.com.mx/developers/panel/app  -> Credenciales de prueba
return [
    'access_token' => '', // TEST-... or APP_USR-... — paste here
    'currency_id'  => 'MXN',
    'base_url'     => '', // optional, e.g. http://localhost:3000 — auto-detected when empty
];
