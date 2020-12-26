<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Design della community</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <form class="my-search-form my-3" action="view_designs.php" method="GET">
        <div id="search-flex">
            <div>
                <div class="my-search-bar d-flex">
                    <input class="form-control" placeholder="Cerca..." type="text" name="searchtext" id="searchtext">
                    <button class="btn ms-2" id="searchDropdown" type="button" data-bs-target="#searchOptions" data-bs-toggle="collapse" aria-expanded="false" aria-controls="searchOptions">
                        <i class="arrow down"></i>
                    </button>
                </div>
                <div class="row collapse align-content-center flex-column" id="searchOptions">
                    <div class="form-group py-2 my-1">
                        <input class="form-check-input" type="radio" name="price-range" value="10" id="under10">
                        <label for="under10">Da 10 in giù</label>
                    </div>
                    <div class="form-group py-2 my-1">
                        <input class="form-check-input" type="radio" name="price-range" value="20" id="under20">
                        <label for="under20">Da 20 in giù</label>
                    </div>
                    <div class="form-group py-2 my-1">
                        <input class="form-check-input" type="radio" name="price-range" value="50" id="under50">
                        <label for="under50">Da 50 in giù</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <input class="btn btn-primary" type="submit" value="Cerca">
            </div>
        </div>
    </form>
<?php

    $base_query = 'SELECT id,name,author,filename,price FROM products';
    // write query for all products
    $query = $base_query;

    $params = array();
    $types = "";
    $first_criteria = true;
    foreach($_GET as $get_param => $value){
        if (array_key_exists($get_param, $criteria_query_assoc) && strlen($value)){
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

    $query .= " ORDER BY id ASC";

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

    $reviews_query = "SELECT product, COUNT(*) as total, AVG(score) AS avg_score FROM reviews GROUP BY product ORDER BY product ASC ";
    $reviews_result = my_oo_query($link, $reviews_query);

    ?> 
    <div id="designs-list" class="d-flex"> <?php
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
            $reviews = mysqli_fetch_assoc($reviews_result);
        ?>

        <div class="design my-4 py-4">
            <h4><?php echo htmlspecialchars($product['name']) ?></h4>
            <div class="design-img-container">
                <img src=<?php echo "uploads/$product[filename]"; ?> alt="Design image">
            </div>
            <div>
                <button class="show-reviews my-2 btn btn-info" prod_id="<?php echo htmlspecialchars($product['id']) ?>" >Questo design ha <?php echo $reviews['total'] ?> reviews </button>
                <div class="hidden">
                    <div class="hidden alert-success" id="<?php echo 'alert-success' 
                            . htmlspecialchars($product['id'])?>">
                        <p>Grazie per averci fatto sapere quello che pensi su questo design!</p>
                    </div>
                    <div class="hidden alert-danger" id="<?php echo 'alert-danger' 
                            . htmlspecialchars($product['id'])?>">
                        <p>La review non è stata inserita correttamente</p>
                    </div>
                    <?php if (isset($_SESSION['userid'])){ ?>
                        <form method="POST">
                            <label class="score-review" for="review_score">Voto: <span>3</span></label>
                            <input class="form-range score-range" min="1" max="5" step="0.5" value="3" type="range" name="review_score" id="<?php echo 'review_score' 
                                . htmlspecialchars($product['id'])?>">
                            <label for="review_score">Recensione:</label>
                            <textarea class="form-control" name="review_text" rows="4" id="<?php echo 'review_text' 
                                . htmlspecialchars($product['id'])?>"></textarea>
                            <input class="btn btn-primary mb-2 review_submit mt-3" type="submit" value="Inviaci la tua opinione!"
                                name = "review_submit"
                                prod_id=<?php echo htmlspecialchars($product['id']) ?>>
                        </form>
                    <?php }?>
                    <ul id="<?php echo 'reviews' . htmlspecialchars($product['id'])?>" ></ul>
                </div>
                <a href="show_profile.php?username=<?php echo htmlspecialchars($display_name); ?>"><span>Da <?php echo htmlspecialchars($display_name) ?></span></a>
                <span>solo €<?php echo htmlspecialchars($product['price']) ?></span>
                <button class="prod_btn my-2 btn btn-secondary" prod_id="<?php echo $product['id'] ?>">Aggiungi al carrello</button>
            </div>
            <p id="<?php echo 'avg_score' . htmlspecialchars($product['id'])?>">
                Voto medio: <?php echo $reviews['avg_score'] ?></p>
        </div>
        
        <?php endforeach; 
        $stmt->close();
        ?>
    </div>
    <script src="js/cart.js"></script>
    <?php
   require("common/footer.php");
   ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <script src="js/reviews_common.js"></script>
    <script src="js/reviews.js"></script>
    <script src="js/send_review.js"></script>
</body>
</html>
