<?php

require_once("../common/db_ops.php");
require_once("../../db_connections/connections.php");
$link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);


$query = "SELECT ";
$fields = array();
$criteria = array();


if (isset($_POST['email'])) {
    $email = mysqli_escape_string($link, $_POST['email']);
    array_push($fields, "email");
    array_push($criteria, "email='$email'");
}
if (isset($_POST['username'])) {
    $username = mysqli_escape_string($link, $_POST['username']);
    array_push($fields, "username");
    array_push($criteria, "username='$username'");
}

$query .= implode(",", $fields) . " FROM users WHERE " . implode(" OR ", $criteria);

$res = my_oo_query($link, $query);
$users = mysqli_fetch_all($res, MYSQLI_ASSOC);

$wrongs = array();
foreach ($fields as $field) {
    $wrongs[$field] = false;
}
foreach ($users as $user) {
    foreach ($fields as $field) {
        $wrongs[$field] = (isset($wrongs[$field]) ? $wrongs[$field] : false) || ($user[$field] === $_POST[$field]);
    }
}

header("Content-type: application/json");
echo json_encode($wrongs);
