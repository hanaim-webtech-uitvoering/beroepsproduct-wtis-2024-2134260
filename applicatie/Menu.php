<?php
require_once 'db_connect.php';
require_once 'functions.php';

session_start();
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $productName = $_POST['product_name'];
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];

  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  }

  if (isset($_SESSION['cart'][$productName])) {
    $_SESSION['cart'][$productName]['quantity'] += $quantity;
  } else {
    $_SESSION['cart'][$productName] = [
      'price' => $price,
      'quantity' => $quantity
    ];
  }

  header('Location: menu.php');
  exit();
}

$menu = getMenu();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu</title>
</head>

<body>
  <?php showNavbar($_SESSION['role']); ?>

  <?php echo $menu; ?>
</body>

</html>