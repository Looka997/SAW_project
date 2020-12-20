<?php
require_once('../common/db_ops.php');
require_once('../common/utilities.php');
require_once("../../db_connections/connections.php");
$link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);

session_start();

if (!isset($_POST['prod_id']) || !isset($_SESSION["userid"])) {
    echo "Usage:\nMethod: POST\n";
    exit(200);
}

$prod_id = mysqli_escape_string($link, $_POST['prod_id']);

$query = "SELECT users.id AS user_id, content, score, IFNULL(username, email) as user FROM reviews JOIN users" .
    " WHERE users.id = author AND product= " . mysqli_escape_string($link, $_POST['prod_id']);
$res = my_oo_query($link, $query);
$reviews = mysqli_fetch_all($res, MYSQLI_ASSOC);

$response = [
    "reviews" => $reviews,
    "id" => $_SESSION["userid"]
];

header("Content-Type: application/json");
echo json_encode($response);
