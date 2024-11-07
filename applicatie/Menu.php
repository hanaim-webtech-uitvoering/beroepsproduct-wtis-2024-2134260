<?php
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
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    </head>
<body>
    <?php echo $menu; ?>
</body>
</html>