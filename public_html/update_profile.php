<?php
session_start();
require_once("common/db_ops.php");
require_once("../db_connections/connections.php");
$link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
require_once("common/utilities.php");
require_once("common/details_reg.php");

$abort = false;
if (!isset($_POST["to_update"]))
    $_POST["to_update"] = $_SESSION["email"];
if (isset($_POST['submit']) && $_SESSION["email"] === $_POST["to_update"]) {
    if (preg_match($fstname_reg, $_POST["firstname"]) == 0) {
        $abort = true;
    }
    if (preg_match($lastname_reg, $_POST["lastname"]) == 0) {
        $abort = true;
    }
    if (preg_match($email_reg, $_POST["email"]) == 0) {
        $abort = true;
    }

    if ($abort) {
        header("Location: show_profile.php");
        exit;
    }

    $new_email = mysqli_escape_string($link, $_POST["email"]);
    $new_firstname = mysqli_escape_string($link, $_POST["firstname"]);
    $new_lastname = mysqli_escape_string($link, $_POST["lastname"]);

    $args = array($new_email, $new_firstname, $new_lastname);

    $update_query = "UPDATE users
                            SET email = ?, firstname = ?, lastname = ? ";
    $types = "sss";

    if (isset($_POST["address"])) {
        $new_address = strlen($_POST["address"]) ? mysqli_escape_string($link, $_POST["address"]) : NULL;
        $update_query .= ", address=?";
        $types .= "s";
        array_push($args, $new_address);
    }
    if (isset($_POST["phone"])) {
        $new_phone = strlen($_POST["phone"]) ? mysqli_escape_string($link, $_POST["phone"]) : NULL;
        $update_query .= ", phone=?";
        $types .= "s";
        array_push($args, $new_phone);
    }
    if (isset($_POST["username"])) {
        $new_username = strlen($_POST["username"]) ? mysqli_escape_string($link, $_POST["username"]) : NULL;
        $update_query .= ", username=?";
        $types .= "s";
        array_push($args, $new_username);
    }

    $update_query .= " WHERE email='" . mysqli_escape_string($link, $_POST["to_update"]) . "'";


    $stmt = my_oo_prepared_stmt($link, $update_query, $types, ...$args);
    if (mysqli_stmt_affected_rows($stmt) === 1) {
        mysqli_stmt_close($stmt);
        $_SESSION["email"] = $new_email;
        $_SESSION["username"] = $new_username;
        header("Location: index.php");
        exit;
    }
    mysqli_stmt_close($stmt);
}
// ho provato a modificare dati non della sessione corrente, 
header("Location: show_profile.php");
exit;
