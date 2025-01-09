<?php
function getMenu()
{
  global $verbinding;

  $query = 'SELECT "name", price FROM Product';

  try {
    $data = $verbinding->query($query);

    $menu = "<table>";
    $menu .= "<tr><th>Product</th><th>Prijs</th></tr>";

    foreach ($data as $row) {
      $product = $row['name'];
      $price = $row['price'];

      $menu .= "<tr><td>$product</td><td>$price</td></tr>";
    }

    $menu .= "</table>";
  } catch (PDOException $e) {
    $menu = "Error retrieving menu: " . $e->getMessage();
  }

  return $menu;
}

function checkUser($username, $password)
{
  global $verbinding;

  $query = 'SELECT username, password, role FROM "User" WHERE username = :username';
  $parameters = [':username' => $username];

  try {
    $statement = $verbinding->prepare($query);
    $statement->execute($parameters);
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if ($row) {
      $hashedPassword = $row['password'];
      if (password_verify($password, $hashedPassword)) {
        unset($row['password']);
        header('Location: menu.php');

        return $row;
      }
    }
    return null;
  } catch (PDOException $e) {
    error_log("Error executing query: " . $e->getMessage());
    return null;
  }
}

function getOrderOverview_P($username)
{
  global $verbinding;

  $query = 'SELECT pop.product_name, pop.quantity, po.status FROM Pizza_Order_Product pop INNER JOIN Pizza_Order po ON pop.order_id = po.order_id WHERE personnel_username = :username';
  $parameters = [':username' => $username];

  $orders = "<table>";
  $orders .= "<tr><th>Product</th><th>Hoeveelheid</th><th>Status</th></tr>";

  try {
    $statement = $verbinding->prepare($query);
    $statement->execute($parameters);
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($rows) {
      foreach ($rows as $row) {
        $productName = $row['product_name'];
        $quantity = $row['quantity'];
        $status = $row['status'];

        $orders .= "<tr><td>$productName</td><td>$quantity</td><td>$status</td></tr>";
      }
    }

    $orders .= "</table>";

    if (sizeof($rows) == 0) {
      $orders = "U heeft nog geen orders";
    }

  } catch (PDOException $e) {
    error_log("Error executing query: " . $e->getMessage());
    return null;
  }

  return $orders;
}

function getOrderOverview_U($username)
{
  global $verbinding;

  $query = 'SELECT pop.product_name, pop.quantity FROM Pizza_Order_Product pop INNER JOIN Pizza_Order po ON pop.order_id = po.order_id WHERE client_username = :username';
  $parameters = [':username' => $username];

  $orders = "<table>";
  $orders .= "<tr><th>Product</th><th>Hoeveelheid</th></tr>";

  try {
    $statement = $verbinding->prepare($query);
    $statement->execute($parameters);
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($rows) {
      foreach ($rows as $row) {
        $productName = $row['product_name'];
        $quantity = $row['quantity'];

        $orders .= "<tr><td>$productName</td><td>$quantity</td></tr>";
      }
    }

    $orders .= "</table>";

    if (sizeof($rows) == 0) {
      $orders = "U heeft nog geen orders";
    }

  } catch (PDOException $e) {
    error_log("Error executing query: " . $e->getMessage());
    return null;
  }

  return $orders;
}

function addUser($username, $password, $first_name, $last_name, $address)
{
  global $verbinding;

  $query = 'INSERT INTO "user" (username, password, first_name, last_name, role, address) VALUES (:username, :password, :first, :last, :role, :address)';
  $parameters = [':username' => $username, ':password' => $password, ':first' => $first_name, ':last' => $last_name, ':role' => 'Client', 'address' => $address];

  try {
    $statement = $verbinding->prepare($query);
    $statement->execute($parameters);

  } catch (PDOException $e) {
    error_log("Error executing query: " . $e->getMessage());
    return null;
  }

  return true;
}

function checkUserExists($username)
{
  global $verbinding;

  $query = 'SELECT username FROM "User" where username = :username';
  $parameters = [':username' => $username];
  try {
    $statement = $verbinding->prepare($query);
    $statement->execute($parameters);
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
      return true;
    } else {
      return false;
    }
  } catch (PDOException $e) {
    error_log("Error executing query: " . $e->getMessage());
    return null;
  }
}
?>