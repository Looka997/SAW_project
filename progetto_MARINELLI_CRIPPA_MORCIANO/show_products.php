<?php

    require_once('common/db_ops.php');
    require_once('common/utilities.php');
    if (!isset($link)){
        require_once('../../db_connections/connections.php');
        $link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
    }

    // write query for all products
    $query = 'SELECT name,author_nickname,filename FROM products';

    // make query and get result
    $result = my_oo_query($link, $query);

    // fetch resulting rows as an array
    $product = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<?php foreach($products as $product): ?>
    <h5><?php echo $product['name'] ?></h5>
    <img src=<?php echo $product['filename']; ?> alt="Product image">
    <p> by <?php echo $product['author_nickname'] ?></p>
    <!-- qua probabilmente un bel average voto -->
<?php endforeach ?>