<?php
require_once 'db_connect.php';
require_once 'functions.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$cart = $_SESSION['cart'] ?? [];
$address = $_SESSION['address'] ?? null;

if (empty($cart) || empty($address)) {
    header('Location: shoppingCart.php');
    exit();
}

$orders = [];
foreach ($cart as $product => $details) {
    $orders[] = [
        'product' => $product,
        'quantity' => $details['quantity'],
    ];
}

addOrder($username, $address, $orders);

unset($_SESSION['cart']);

header('Location: profile.php');
exit();
?>
