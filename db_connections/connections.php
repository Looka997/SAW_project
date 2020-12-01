<?php

    require_once("credentials.php");
        
    function my_connect($host, $db_user, $db_password, $database){
        $db_con = mysqli_connect($host,$db_user,$db_password,$database);
        if (!$db_con){
            echo mysqli_connect_error();
            exit;
        }
        return $db_con;
    }

    function my_oo_connect($host, $db_user, $db_password, $database){
        $db_con = new mysqli($host, $db_user, $db_password, $database);
        if ($db_con->connect_error)
            die($db_con->connect_error);
        return $db_con;
    }


?>
