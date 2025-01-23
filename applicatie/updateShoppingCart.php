<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];

    if (!is_numeric($quantity) || $quantity <= 0) {
        $_SESSION['error'] = 'De hoeveelheid moet een geldig getal zijn en groter dan nul';
        header('Location: shoppingCart.php');
        exit();
    }

    if (isset($_SESSION['cart'][$product])) {
        $_SESSION['cart'][$product]['quantity'] = $quantity;
        unset($_SESSION['error']);
    }

    header('Location: shoppingCart.php');
    exit();
}