<?php
require_once 'db_connect.php';
require_once 'functions.php';

session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelmandje</title>
</head>

<body>
    <nav>
        <ul>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="shoppingCart.php">Winkelmandje</a></li>
            <li><a href="profile.php">Profiel</a></li>
            <?php if ($_SESSION['role'] == 'Personnel'): ?>
                <li><a href="orderOverview.php">bestelling overzicht</a></li>
                <li><a href="detailOverview.php">Detail overzicht</a></li>
            <?php endif; ?>
            <li><a href="privacyverklaring.php">Privacyverklaring</a></li>
        </ul>
    </nav>
    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</body>

</html>