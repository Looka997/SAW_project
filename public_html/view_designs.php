<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

    $base_query = 'SELECT id,name,author,filename,price FROM products';
    // write query for all products
    $query = $base_query;

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
        $query = $base_query;
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
        $display_name = is_null($authorusername)? $authoremail : $authorusername;

        $reviews_query = "SELECT COUNT(*) as total FROM reviews WHERE product = $product[id]";
        $reviews_result = my_oo_query($link, $reviews_query);
        $reviews = mysqli_fetch_row($reviews_result);
        
    ?>
    <h4><?php echo htmlspecialchars($product['name']) ?></h4>
    <img src=<?php echo "uploads/$product[filename]"; ?> alt="Design image">
    <div>
        <button class="show-reviews" prod_id="<?php echo htmlspecialchars($product['id']) ?>" >This design has <?php echo $reviews[0] ?> reviews </button>
        <ul id="<?php echo 'reviews' . $product['id']?>" class="hidden"></ul>
        <a href="show_profile.php?username=<?php echo htmlspecialchars($display_name); ?>"><span>by <?php echo htmlspecialchars($display_name) ?></span></a>
        <span>only <?php echo htmlspecialchars($product['price']) ?></span>
        <button class="prod_btn" prod_id="<?php echo $product['id'] ?>">Aggiungi al carrello</button>
    </div>
    
    <!-- qua probabilmente un bel average voto -->
    <?php endforeach; 
    $stmt->close();
    ?>

    <script src="js/cart.js"></script>
    <?php
   require("common/footer.php");
   ?>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>  

    <script src="js/reviews.js"></script>
</body>
</html>
