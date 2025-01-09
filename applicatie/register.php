<?php
require_once 'db_connect.php';
require_once 'functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (empty($_POST['username'])) {
    $error .= "Gebruikersnaam is verplicht. <br> ";
  } else {
    $username = htmlspecialchars(trim($_POST['username']));
  }

  if (empty($_POST['password'])) {
    $error .= "Wachtwoord is verplicht. <br> ";
  } else {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  }

  if (empty($_POST['first_name'])) {
    $error .= "Voornaam is verplicht. <br> ";
  } else {
    $first_name = htmlspecialchars(trim($_POST['first_name']));
  }

  if (empty($_POST['last_name'])) {
    $error .= "Achternaam is verplicht. <br> ";
  } else {
    $last_name = htmlspecialchars(trim($_POST['last_name']));
  }

  $address = !empty($_POST['address']) ? htmlspecialchars(trim($_POST['address'])) : null;

  if ($error === '') {
    if (!checkUserExists($username)) {
      if (addUser($username, $password, $first_name, $last_name, $address)) {
        header('Location: login.php');
        exit();
      }
    } else {
      $error = 'Gebruikersnaam bestaat al';
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registreren</title>
</head>

<body>
  <h1>Registreren</h1>

  <?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
  <?php endif; ?>

  <form action="" method="post">
    <label for="username">Gebruikersnaam:</label><br>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Wachtwoord:</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <label for="first_name">Voornaam:</label><br>
    <input type="text" id="first_name" name="first_name" required><br><br>

    <label for="last_name">Achternaam:</label><br>
    <input type="text" id="last_name" name="last_name" required><br><br>

    <label for="address">adres:</label><br>
    <input type="text" id="address" name="address"><br><br>

    <button type="submit">Registreer</button>
  </form>
</body>

</html>