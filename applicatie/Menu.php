<?php
  require_once 'db_connect.php';
  require_once 'functions.php';
  
  session_start();
  if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
  }
  
  $menu = getMenu(); 
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    </head>
<body>
    <form action="logout.php" method="post">
      <button type="submit">Logout</button>
    </form>
    <?php echo $menu; ?>
</body>
</html>