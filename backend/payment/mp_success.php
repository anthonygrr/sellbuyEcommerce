<?php
// Mercado Pago Checkout Pro success back_url.
// Trust model: no IPN webhook in local dev, so the payment is re-verified
// server-side against the MP API before any order row is marked as paid.
// The verification itself lives in mp_reconcile.php, which is also re-run
// lazily from order.php/cart.php when this return trip is lost.
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

// Verify against MP and mark the cart paid when an approved payment exists.
require_once __DIR__ . '/mp_reconcile.php';
if (mp_reconcile_mark_paid($ref)) {
    unset($_SESSION['mp_pending_ref']);
    header('Location: /pages/checkout/order.php?mp=success');
    exit;
}
header('Location: /pages/checkout/order.php?mp=unverified');
exit;
