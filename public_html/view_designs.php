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
    require_once("classes/SearchQuery.php");

?>
    <form action="view_designs.php" method="GET">
        <input placeholder="Search..." type="text" name="searchtext" id="searchtext">
        <label for="from0to10">From 0 to 10</label>
        <input type="radio" name="from0to10" id="from0to10">
        <label for="from10to20">From 10 to 20</label>
        <input type="radio" name="from10to20" id="from10to20">
        <label for="over20">Over 20</label>
        <input type="radio" name="over20" id="over20">
        <input type="submit" value="submit">
    </form>
<?php


    // write query for all products
    $query = 'SELECT name,author,filename,price FROM products';

    $params = array();
    $types = "";
    $first_criteria = true;
    foreach($_GET as $get_param => $value){
        if (isset($criteria_query_assoc[$get_param]) && strlen($value)){
            if ($criteria_query_assoc[$get_param]->argc){
                $types.= $criteria_query_assoc[$get_param]->type;
                array_push($params, $value);
            }
            if ($first_criteria){
                $query.= " WHERE " . $criteria_query_assoc[$get_param]->query;
                $first_criteria = false;
                continue;
            }
            $query.= " AND " . $criteria_query_assoc[$get_param]->query;
        }
    }
    $stmt = my_oo_prepared_stmt($link, $query, $types, ...$params);
    if ($stmt->errno){
        $query = 'SELECT name,author,filename,price FROM products';
        $result = my_oo_query($link, $query);
    }else{
        $result = $stmt->get_result();
    }

    // fetch resulting rows as an array
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // qui ci sarà da guardare, per ogni autore, a chi corrisponde lo userid
    ?>
    <?php 
    $query = "SELECT email, username FROM users
                WHERE id=?";

    if ($stmt = $link->prepare($query)){
        $stmt->bind_param("i",$authorid);
    }else{
        echo $con->error;
        exit;
    }

    foreach($products as $product): 
        $authorid = $product['author'];
        if ($stmt->execute()){
            $stmt->store_result();
            if ($stmt->num_rows > 0){
                $stmt->bind_result($authoremail, $authorusername);
                $stmt->fetch();
            }
        }
    ?>
    <h4><?php echo htmlspecialchars($product['name']) ?></h4>
    <img src=<?php echo "uploads/$product[filename]"; ?> alt="Design image">
    <div>
        <?php // lavorare su prepared statement ?>
        <span>by <?php echo htmlspecialchars(is_null($authorusername)? $authoremail : $authorusername ) ?></span> 
        <span>only <?php echo htmlspecialchars($product['price']) ?></span>
    </div>
    
    <!-- qua probabilmente un bel average voto -->
    <?php endforeach; 
    $stmt->close();
    ?>
</body>
</html>
