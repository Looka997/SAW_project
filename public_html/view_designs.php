<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
    session_start();
    require_once('common/db_ops.php');
    require_once('common/utilities.php');
    if (!isset($link)){
        require_once("../db_connections/connections.php");
        $link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
    }

    require_once("common/navbar.php");

    // write query for all products
    $query = 'SELECT name,author,filename, price FROM products';

    // make query and get result
    $result = my_oo_query($link, $query);

    // fetch resulting rows as an array
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // qui ci sarà da guardare, per ogni autore, a chi corrisponde lo userid
    ?>
    <?php 
    // $query = "SELECT email, username FROM users
    //             WHERE id=?";
    foreach($products as $product): ?>
    <h4><?php echo htmlspecialchars($product['name']) ?></h4>
    <img src=<?php echo "uploads/$product[filename]"; ?> alt="Design image">
    <div>
        <?php // lavorare su prepared statement ?>
        <span>by <?php echo htmlspecialchars($product['author']) ?></span> 
        <span>only <?php echo htmlspecialchars($product['price']) ?></span>
    </div>
    
    <!-- qua probabilmente un bel average voto -->
    <?php endforeach ?>
</body>
</html>
