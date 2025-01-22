<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$product])) {
        $_SESSION['cart'][$product]['quantity'] = $quantity;
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$product]);
        }
    }

    header('Location: shoppingCart.php');
    exit();
}