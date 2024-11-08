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
?>