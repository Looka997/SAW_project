<?php 
    session_start();
    if (!isset($_SESSION["email"])){
        $_SESSION["create_POST"] = $_POST;
        header("Location: login.php");
        exit;
    }

    //only for testing, to remove later
    $_SESSION["create_POST"] = $_POST;
    header("Location: create.php");
    //

?>