<?php
require_once 'db_connect.php';
require_once 'functions.php';

session_start();

if (isset($_SESSION['username'])) {
  header('Location: menu.php');
  exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $result = checkUser($username, $password);

  if ($result) {
    $_SESSION['username'] = $result['username'];
    $_SESSION['role'] = $result['role'];
    header('Location: menu.php');
    exit();
  } else {
    $error = 'Uw gebruikersnaam of wachtwoord is verkeerd.';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
</head>

<body>
  <h1>Login</h1>

  <?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
  <?php endif; ?>

  <form action="" method="POST">
    <label for="username">Username:</label>
    <br>
    <input type="text" id="username" name="username" required>
    <br><br>
    <label for="password">Password:</label>
    <br>
    <input type="password" id="password" name="password" required>
    <br><br>
    <button type="submit">Login</button>
  </form>
</body>

</html>