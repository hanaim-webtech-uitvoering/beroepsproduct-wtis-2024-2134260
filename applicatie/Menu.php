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
  $quantity = $_POST['quantity'];

  if (is_numeric($quantity)) {
    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$productName])) {
      $_SESSION['cart'][$productName]['quantity'] += $quantity;
    } else {
      $_SESSION['cart'][$productName] = [
        'quantity' => $quantity
      ];
    }

    header('Location: menu.php');
    exit();
  } else {
    $error = 'De hoeveelheid moet een getal zijn';
  }
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
  
  <?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
  <?php endif; ?>
  
  <?php echo $menu; ?>
</body>

</html>