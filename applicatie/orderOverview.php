<?php
require_once 'db_connect.php';
require_once 'functions.php';

session_start();
if (!isset($_SESSION['username']) && !isset($_SESSION['role']) && $_SESSION['role'] == 'Personnel') {
  header('Location: login.php');
  exit();
}

$orders = getOrderOverview_P($_SESSION['username']);
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders</title>
</head>

<body>
  <nav>
    <ul>
      <li><a href="menu.php">Menu</a></li>
      <li><a href="winkelmandje.php">Winkelmandje</a></li>
      <li><a href="profile.php">Profiel</a></li>
      <li><a href="orderOverview.php">bestelling overzicht</a></li>
      <li><a href="detailOverview.php">Detail overzicht</a></li>
      <li><a href="privacyverklaring.php">Privacyverklaring</a></li>
    </ul>
  </nav>
  <form action="logout.php" method="post">
    <button type="submit">Logout</button>
  </form>
  <?php echo $orders; ?>
</body>

</html>