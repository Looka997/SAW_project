<?php
require_once('../common/db_ops.php');
require_once('../common/utilities.php');
require_once("../../db_connections/connections.php");
$link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);

if (!isset($_POST['prod_id'])) {
    echo "Usage:\nMethod: POST\n";
    exit(200);
}

$prod_id = mysqli_escape_string($link, $_POST['prod_id']);

$query = "SELECT content, score, author FROM reviews" .
    " WHERE product= " . mysqli_escape_string($link, $_POST['prod_id']);
$res = my_oo_query($link, $query);
$reviews = mysqli_fetch_all($res, MYSQLI_ASSOC);


header("Content-Type: application/json");
echo json_encode($reviews);
