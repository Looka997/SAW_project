<?php
    session_start();
    $_SESSION = array();
    setcookie(session_name(), "", 0);
    session_unset();
    session_destroy();
    header("Location: ../view_login.php");
    exit;
?>

