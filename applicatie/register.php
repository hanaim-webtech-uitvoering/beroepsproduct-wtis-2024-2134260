<?php
require_once 'db_connect.php';
require_once 'functions.php';

$username = $_POST['username'];
$password = $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$address = $_POST['address'];

if(addUser($username, $password, $first_name,$last_name, $address)){
  header('Location: login.php');
  exit();
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