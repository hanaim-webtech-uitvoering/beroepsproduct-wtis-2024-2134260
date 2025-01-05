<?php
function getMenu() {

    require_once 'db_connect.php';

      $query = 'SELECT "name", price FROM Product';
  
      try{
        $db = maakVerbinding();
        $data = $db->query($query);
    
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

function checkUser($username, $password) {
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
?>