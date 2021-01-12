<?php
session_start();
require_once("common/db_ops.php");
require_once("../db_connections/connections.php");
$link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);

$query = "DELETE FROM mail_list WHERE email_follower=? AND email_creator=?";
$types = "ss";
$stmt = my_oo_prepared_stmt($link, $query, $types, $_SESSION["email"], $_POST["redirect"]); 

header("Location: show_profile.php?email=".$_POST["redirect"]);
exit;
