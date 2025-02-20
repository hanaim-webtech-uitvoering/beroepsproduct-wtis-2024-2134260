<?php
require_once 'db_connect.php';
require_once 'functions.php';

session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Personnel') {
  header('Location: login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['order_id']) && isset($_POST['status'])) {
    $orderId = intval($_POST['order_id']);
    $status = intval($_POST['status']);

    $validIds = getValidId($_SESSION['username']); 

    if (in_array($orderId, $validIds)) {
      if ($status >= 1 && $status <= 3) {
        updateStatus($orderId, $status);
        $message = "Status is geüpdate";
      } else {
        $message = "Status moet 1, 2 of 3 zijn";
      }
    } else {
      $message = "Je mag alleen je eigen orders updaten";
    }
  } else {
    $message = "Ongeldige input";
  }
}

$orders = getOrderOverview_P($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders</title>
</head>

<body>
  <?php showNavbar($_SESSION['role']); ?>

  <?php
  if (isset($message)) {
    echo "<p>$message</p>";
  }
  ?>

  <?php echo $orders; ?>
</body>

</html>