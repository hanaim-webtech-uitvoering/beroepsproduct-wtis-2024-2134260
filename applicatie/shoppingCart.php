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
  
  <?php if (empty($cart)): ?>
    <p>Uw winkelmandje is leeg</p>
  <?php else: ?>
    <table>
      <tr>
        <th>Product</th>
        <th>Prijs</th>
        <th>Aantal</th>
      </tr>
      <?php foreach ($cart as $product => $details): ?>
        <tr>
          <td><?= $product ?></td>
          <td>€<?= $details['price'] ?></td>
          <td><?= $details['quantity'] ?></td>
          <td>
            <form action="updateShoppingCart.php" method="post">
              <input type="hidden" name="product" value="<?= $product ?>">
              <input type="number" name="quantity" value="<?= $details['quantity'] ?>" min="1">
              <button type="submit">Update</button>
            </form>
            <form action="removeFromShoppingCart.php" method="post">
              <input type="hidden" name="product" value="<?= $product ?>">
              <button type="submit">Verwijder</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>

    <form action="" method="post">
      <label for="address">Voer uw adres in:</label>
      <input type="text" id="address" name="address" value="<?= isset($address) && !is_null($address) ? htmlspecialchars($address) : '' ?>" required>
      <button type="submit">Opslaan</button>
    </form>
    <?php if (isset($error)): ?>
      <p><?= $error ?></p>
    <?php endif; ?>

    <?php if ($address): ?>
      <p>Huidig adres: <?= htmlspecialchars($address) ?></p>
      <form action="checkout.php" method="post">
        <button type="submit">Afrekenen</button>
      </form>
    <?php endif; ?>
  <?php endif; ?>
</body>

</html>