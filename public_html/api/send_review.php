<?php
require_once('../common/db_ops.php');
require_once('../common/utilities.php');
require_once('../common/error_codes.php');
require_once("../../db_connections/connections.php");
$link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
session_start();
function view_name()
{
    return $_SESSION["username"] === NULL
        ? $_SESSION["email"]
        : $_SESSION["username"];
}

if (
    (!isset($_POST['product']))
    || (!isset($_POST['content']))
    || (!isset($_SESSION['userid']))
    || (!isset($_POST['score'])
    || $_POST['score'] < 1
    || $_POST['score'] > 5)
) {
    echo "Usage:\nRequires:Logged user\n
            Method: POST\n
            Payload: score=number&content=text&product=prod_id\n
            Score between 1 and 5\n";
    exit(200);
}


$query = "INSERT INTO reviews (content, score, product, author) VALUES
    (?, ?, ?, ?)";
$types = "sdii";
$stmt = my_oo_prepared_stmt(
    $link,
    $query,
    $types,
    $_POST['content'],
    $_POST['score'],
    $_POST['product'],
    $_SESSION['userid']
);

$result = [];
if ($stmt->errno)
    $result['error'] = $stmt->errno === 1062 ? DB_DUP_ERR : DB_GENERIC_ERR;
else {
    $result['success'] = OK;
}


$stmt->close();

header("Content-Type: application/json");
echo json_encode($result);
