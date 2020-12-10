<?php
    require_once("../../db_connections/connections.php");
    $link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);

    require_once('../common/db_ops.php');
    require_once('../common/utilities.php');

    $query = 'SELECT filename, name FROM models';
    $result = my_oo_query($link, $query);
    $models = mysqli_fetch_all($result,  MYSQLI_ASSOC);
    
    header("content-type: application/json");

    if (!($answer = json_encode($models))) {
        echo "{\"error\": \"Errore in json_encode\"}";
        die();
    }

    echo $answer;
?>