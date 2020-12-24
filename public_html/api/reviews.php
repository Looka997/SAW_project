<?php
require_once('../common/db_ops.php');
require_once('../common/utilities.php');
require_once("../../db_connections/connections.php");
$link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);

session_start();

if (!isset($_POST['product'])){
    echo "Usage:\n
        Method: POST\n";
    exit(200);
}

$response = [];
if (isset($_SESSION['userid']))
    $response['id'] = $_SESSION['userid'];
$prod_id = mysqli_escape_string($link, $_POST['product']);

$fields = array();
if (isset($_POST['avg_score']) )
    $fields['avg_score'] = "AVG(score) as avg_score";
if (isset($_POST['count']) )
    $fields['count'] = "COUNT(*) as total";

if (count($fields)){
    $avg_count_query = "SELECT " . implode(",",$fields) . " FROM reviews WHERE product = $prod_id";
    $avg_count_query_result = my_oo_query($link, $avg_count_query);
    $avg_count = mysqli_fetch_assoc($avg_count_query_result);

    if (isset($avg_count['total']))
        $response['count'] = $avg_count['total'];
    if (isset($avg_count['avg_score']))
        $response['avg_score'] = $avg_count['avg_score'];
}

if (isset($_POST['reviews'])){
    $reviews_query = "SELECT users.id AS user_id, content, score, 
        IFNULL(username, email) as user FROM reviews JOIN users" .
        " WHERE users.id = author AND product= " . 
        mysqli_escape_string($link, $_POST['product']);
    $res = my_oo_query($link, $reviews_query);
    $reviews = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $response['reviews'] = $reviews;
}

header("Content-Type: application/json");
echo json_encode($response);
