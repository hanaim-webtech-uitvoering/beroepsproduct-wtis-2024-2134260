<?php
function getMenu()
{
  global $verbinding;

  $query = 'SELECT name, price FROM Product';

  try {
    $data = $verbinding->query($query);

    $menu = "<table>";
    $menu .= "<tr><th>Product</th><th>Prijs</th></tr>";

    foreach ($data as $row) {
      $product = $row['name'];
      $price = $row['price'];

      $menu .= "<tr><td>$product</td><td>€$price</td><td>
                    <form action='menu.php' method='post'>
                      <input type='hidden' name='product_name' value=\"$product\">
                      <input type='hidden' name='price' value=\"$price\">
                      <input type='number' name='quantity' min='1' value='1' required>
                      <button type='submit'>Voeg toe aan uw winkelmandje</button>
                    </form>
                  </td>
                </tr>";
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

  $query = 'SELECT username, password, role, address FROM "User" WHERE username = :username';
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

  $query = 'SELECT pop.product_name, pop.quantity, po.status, po.order_id FROM Pizza_Order_Product pop INNER JOIN Pizza_Order po ON pop.order_id = po.order_id WHERE personnel_username = :username';
  $parameters = [':username' => $username];

  $orders = "<table>";
  $orders .= "<tr><th>Product</th><th>Hoeveelheid</th><th>Status</th><th>Update status</th></tr>";

  try {
    $statement = $verbinding->prepare($query);
    $statement->execute($parameters);
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($rows) {
      foreach ($rows as $row) {
        $productName = $row['product_name'];
        $quantity = $row['quantity'];
        $status = $row['status'];
        $orderId = $row['order_id'];

        $orders .= "<tr><td>$productName</td><td>$quantity</td><td>$status</td><td>
              <form action='orderOverview.php' method='POST'>
                <input type='hidden' name='order_id' value='$orderId'>
                <input type='hidden' name='status' value='" . ($status - 1) . "'>
                <button type='submit' " . ($status <= 1 ? 'disabled' : '') . ">-1</button>
              </form>
              <form action='orderOverview.php' method='POST'>
                <input type='hidden' name='order_id' value='$orderId'>
                <input type='hidden' name='status' value='" . ($status + 1) . "'>
                <button type='submit' " . ($status >= 3 ? 'disabled' : '') . ">+1</button>
              </form>
            </td></tr>";
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

  $query = 'SELECT po.order_id, pop.product_name, pop.quantity, po.status FROM Pizza_Order_Product pop INNER JOIN Pizza_Order po ON pop.order_id = po.order_id WHERE client_username = :username';
  $parameters = [':username' => $username];

  $orders = "<table>";
  $orders .= "<tr><th>Id</th><th>Product</th><th>Hoeveelheid</th><th>Status</th></tr>";

  try {
    $statement = $verbinding->prepare($query);
    $statement->execute($parameters);
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($rows) {
      foreach ($rows as $row) {
        $id = $row['order_id'];
        $productName = $row['product_name'];
        $quantity = $row['quantity'];
        $status = $row['status'];

        $orders .= "<tr><td>$id</td><td>$productName</td><td>$quantity</td><td>$status</td></tr>";
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

function getDetailOverview($username)
{
  global $verbinding;

  $query = 'SELECT po.order_id, po.client_name, po.status, po.address, po.datetime, pop.product_name, pop.quantity FROM Pizza_Order po INNER JOIN Pizza_Order_Product pop ON po.order_id = pop.order_id WHERE po.personnel_username = :username';
  $parameters = [':username' => $username];

  $orders = "<table>";
  $orders .= "<tr><th>order id</th><th>client</th><th>status</th><th>adres</th><th>geplaatst</th><th>artikel</th><th>hoeveelheid</th></tr>";

  try {
    $statement = $verbinding->prepare($query);
    $statement->execute($parameters);
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($rows) {
      foreach ($rows as $row) {
        $orderId = $row['order_id'];
        $client = $row['client_name'];
        $status = $row['status'];
        $address = $row['address'];
        $placedOn = $row['datetime'];
        $productName = $row['product_name'];
        $quantity = $row['quantity'];

        $orders .= "<tr><td>$orderId</td><td>$client</td><td>$status</td><td>$address</td><td>$placedOn</td><td>$productName</td><td>$quantity</td></tr>";
      }
    }

    $orders .= "</table>";

    if (sizeof($rows) == 0) {
      $orders = "U heeft nog geen orders toegekend gekregen";
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

function addOrder($username, $address, $orders)
{
  global $verbinding;
  $usernameP = getRandomPersonnel();

  $query = "INSERT INTO Pizza_Order (client_name, client_username, personnel_username, datetime, status, address) VALUES (:name, :username, :usernameP, GETDATE(), 1, :address);";
  $parameters = [":name" => $username, ":username" => $username, ":usernameP" => $usernameP, ":address" => $address];

  try {
    $statement = $verbinding->prepare($query);
    $statement->execute($parameters);

    $id = getHighestId($username);
    addOrderItems($id, $orders);
  } catch (PDOException $e) {
    error_log("Error executing query: " . $e->getMessage());
    return null;
  }
}

function addOrderItems($id, $orders)
{
  global $verbinding;

  var_dump($orders);
  var_dump($id);

  foreach ($orders as $order) {
    $name = $order["product"];
    $quantity = $order["quantity"];

    $query = "INSERT INTO Pizza_Order_Product(order_id, product_name, quantity) VALUES (:id, :name, :quantity)";
    $parameters = [":id" => $id, ":name" => $name, ":quantity" => $quantity];
    try {
      $statement = $verbinding->prepare($query);
      $statement->execute($parameters);
    } catch (PDOException $e) {
      error_log("Error executing query: " . $e->getMessage());
      return null;
    }
  }
}

function getHighestId($username)
{
  global $verbinding;

  $query = "SELECT MAX(order_id) as max_id FROM Pizza_Order WHERE client_name = :username";
  $parameters = [":username" => $username];
  try {
    $statement = $verbinding->prepare($query);
    $statement->execute($parameters);
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result['max_id'];
  } catch (PDOException $e) {
    error_log("Error executing query: " . $e->getMessage());
    return null;
  }

}

function getRandomPersonnel()
{
  global $verbinding;

  $query = 'SELECT username FROM "User" WHERE role = :role';
  $parameters = [':role' => 'Personnel'];
  try {
    $statement = $verbinding->prepare($query);
    $statement->execute($parameters);
    $usernames = $statement->fetchAll(PDO::FETCH_COLUMN);
    if (!empty($usernames)) {
      return $usernames[array_rand($usernames)];
    } else {
      return null;
    }
  } catch (PDOException $e) {
    error_log('Error executing query: ' . $e->getMessage());
    return null;
  }
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

function updateStatus($id, $status)
{
  global $verbinding;

  $query = 'UPDATE Pizza_Order SET status = :status WHERE order_id = :id';
  $parameters = [':status' => $status, ':id' => $id];
  try {
    $statement = $verbinding->prepare($query);
    $statement->execute($parameters);
  } catch (PDOException $e) {
    error_log('Error executing query: ' . $e->getMessage());
  }
}

function getValidId($username)
{
  global $verbinding;

  $query = 'SELECT order_id FROM Pizza_Order WHERE personnel_username = :username';
  $parameters = [':username' => $username];
  try {
    $statement = $verbinding->prepare($query);
    $statement->execute($parameters);
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($rows) {
      $idArray = [];

      foreach ($rows as $row) {
        $orderId = $row['order_id'];
        $idArray[] = $orderId;
      }

      return $idArray;
    } else {
      return [];
    }
  } catch (PDOException $e) {
    error_log('Error executing query: ' . $e->getMessage());
    return [];
  }
}

function showNavbar($role) {
    echo '<nav>
            <ul>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="shoppingCart.php">Winkelmandje</a></li>
                <li><a href="profile.php">Profiel</a></li>';

    if ($role == 'Personnel') {
      echo '<li><a href="orderOverview.php">bestelling overzicht</a></li>
              <li><a href="detailOverview.php">Detail overzicht</a></li>';
    }

    echo '<li><a href="privacyverklaring.php">Privacyverklaring</a></li>
          </ul>
        </nav>
        <form action="logout.php" method="post">
          <button type="submit">Logout</button>
        </form>';
}

function showCartTable($cart) {
    if (empty($cart)) {
        return '<p>Uw winkelmandje is leeg</p>';
    }

    $table = '<table>';
    $table .= '
        <thead>
            <tr>
                <th>Product</th>
                <th>Prijs</th>
                <th>Aantal</th>
            </tr>
        </thead>
        <tbody>
    ';

    foreach ($cart as $product => $details) {
        $table .= '<tr>';
        $table .= '<td>' . $product . '</td>';
        $table .= '<td>€' . $details['price'] . '</td>';
        $table .= '<td>' . $details['quantity'] . '</td>';
        $table .= '
            <td>
                <form action="updateShoppingCart.php" method="post">
                    <input type="hidden" name="product" value="' . $product . '">
                    <input type="number" name="quantity" value="' . $details['quantity'] . '" min="1">
                    <button type="submit">Update</button>
                </form>
                <form action="removeFromShoppingCart.php" method="post" >
                    <input type="hidden" name="product" value="' . $product . '">
                    <button type="submit">Verwijder</button>
                </form>
            </td>
        ';
        $table .= '</tr>';
    }

    $table .= '</tbody></table>';
    return $table;
}

function showAddressForm($address, $error = null) {
    $form = '
        <form action="" method="post">
            <label for="address">Voer uw adres in:</label>
            <input type="text" id="address" name="address" 
                   value="' . htmlspecialchars($address ?? '') . '" required>
            <button type="submit">Opslaan</button>
        </form>
    ';

    if (!empty($error)) {
        $form .= '<p style="color: red;">' . htmlspecialchars($error) . '</p>';
    }

    if (!empty($address)) {
        $form .= '<p>Huidig adres: ' . htmlspecialchars($address) . '</p>';
        $form .= '
            <form action="checkout.php" method="post">
                <button type="submit">Afrekenen</button>
            </form>
        ';
    }

    return $form;
}