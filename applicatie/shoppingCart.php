<?php
require_once 'functions.php';

session_start();
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

$cart = $_SESSION['cart'] ?? [];
$address = $_SESSION['address'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['address'])) {
  $address = htmlspecialchars(trim($_POST['address']));
  if (!empty($address)) {
    $_SESSION['address'] = $address;
  } else {
    $error = "Adres is verplicht.";
  }
}

$errorQuantity = $_SESSION['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Winkelmandje</title>
</head>

<body>
  <?php showNavbar($_SESSION['role']); ?>
  
  <?php if (!empty($errorQuantity)): ?>
    <p style="color: red;"><?php echo $errorQuantity; ?></p>
  <?php endif; ?>
  
    <?= showCartTable($cart); ?>

    <?php if (!empty($cart)): ?>
        <?= showAddressForm($address, $error ?? null); ?>
    <?php endif; ?>

  </body>

</html>