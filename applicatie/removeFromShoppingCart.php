<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = $_POST['product'];

    if (isset($_SESSION['cart'][$product])) {
        unset($_SESSION['cart'][$product]);
    }

    header('Location: shoppingCart.php');
    exit();
}