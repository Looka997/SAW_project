<?php
require_once('../common/db_ops.php');
require_once('../common/utilities.php');
require_once("../../db_connections/connections.php");
$link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);

if (!isset($_POST['cart'])) {
    echo "Usage:\nMethod: POST\nPayload: cart: [1,2,3,4,..]\n";
    exit(200);
}

$prod_ids = json_decode($_POST['cart']);

if (is_null($prod_ids)) {
    http_response_code(500);
    exit(500);
}

$query = "SELECT products.id, products.name, products.model, products.price, users.username " .
    "FROM products INNER JOIN users ON users.id = products.author " .
    "WHERE products.id = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $current_id);

$res = array();
foreach ($prod_ids as $prod_id) {
    $current_id = $prod_id;

    if (!$stmt->execute()) {
        http_response_code(500);
        die(500);
    }

    $result = $stmt->get_result();
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        array_push($res, $row);
    }
}

header("Content-Type: application/json");
echo json_encode($res);
