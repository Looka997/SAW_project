
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign-up</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php

use function PHPSTORM_META\map;

session_start(); 
    require_once("../db_connections/connections.php");
    $link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
    if (isset($_SESSION["email"])){
        header("Location: index.php");
        exit;
    }

    $found = false;
    $abort = false;
    if (isset($_POST['submit'])){
        if (isset($_SESSION['registration_POST'])){
            unset($_SESSION["registration_POST"]);
        }

        /* TODO: sistemare segnalazione errori */
        require_once("common/details_reg.php"); 
        if (preg_match($fstname_reg, $_POST["firstname"]) === 0 || !is_valid_length($_POST["firstname"], $min_len["firstname"], $max_len["lastname"])){
            echo "<h1> First name is not valid </h1>"; 
            unset($_POST["firstname"]);
            $abort = true;
        }
        if (preg_match($lastname_reg, $_POST["lastname"]) === 0 || !is_valid_length($_POST["lastname"], $min_len["lastname"], $max_len["lastname"])){
            echo "<h1> Last name is not valid </h1>";
            unset($_POST["lastname"]);
            $abort = true;
        }
        if (preg_match($email_reg, $_POST["email"]) === 0 || !is_valid_length($_POST["email"], $min_len["email"], $max_len["email"])){
            echo "<h1> email is not valid </h1>";
            unset($_POST["email"]);
            $abort = true;
        }
        if (preg_match($pass_reg, $_POST["pass"]) === 0 || !is_valid_length($_POST["pass"], $min_len["pass"], $max_len["pass"])){
            echo "<h1> password is not valid </h1>";
            $abort = true;
        } else if ($_POST["pass"] != $_POST["confirm"] || !is_valid_length($_POST["confirm"], $min_len["pass"], $max_len["pass"])){
            echo "<h1> password does not match </h1>";
            $abort = true;
        }
        if (strlen($_POST["username"])){
            if (preg_match($pass_reg, $_POST["username"]) === 0 || !is_valid_length($_POST["username"], $min_len["username"], $max_len["username"])){
                echo "<h1> username is not valid </h1>";
                unset($_POST["username"]);
                $abort = true;
            }
        }
        if (strlen($_POST["address"])){
            if (preg_match($pass_reg, $_POST["address"]) === 0 || !is_valid_length($_POST["address"], $min_len["address"], $max_len["address"])){
                echo "<h1> address is not valid </h1>";
                unset($_POST["addres"]);
                $abort = true;
            }
        }
        if (strlen($_POST["phone"])){
            if (preg_match($pass_reg, $_POST["phone"]) === 0 || !is_valid_length($_POST["phone"], $min_len["phone"], $max_len["phone"])){
                echo "<h1> phone is not valid </h1>";
                unset($_POST["phone"]);
                $abort = true;
            }
        }
        if ($abort){
            unset($_POST["pass"]);
            unset($_POST["confirm"]);
            $_SESSION["registration_POST"] = $_POST; 
            header("Location: view_registration.php");
            exit;
        }


        // create user if it doesn't exist
        require_once("common/db_ops.php");
        require_once("common/utilities.php");
        
        // defined in common/db_ops.php
        $email = mysqli_escape_string($link, $_POST["email"]);
        $firstname = mysqli_escape_string($link, $_POST["firstname"]);
        $lastname = mysqli_escape_string($link, $_POST["lastname"]);
        $args = array($email, password_hash($_POST["pass"], PASSWORD_DEFAULT), $firstname, $lastname);
        $types = "ssss";
        $query = "INSERT into users";
        $fields = " (email, password, firstname, lastname";
        $values = " VALUES (?, ?, ?, ?";

        if (strlen($_POST["username"])){
            $fields.= ", username";
            $values.= ", ?";
            $types .= "s";
            array_push($args, $_POST["username"]);
        }
        if (strlen($_POST["address"])){
            $fields.= ", address";
            $values.= ", ?";
            $types .= "s";
            array_push($args, $_POST["address"]);
        }
        if (strlen($_POST["phone"])){
            $fields.= ", phone";
            $values.= ", ?";
            $types .= "s";
            array_push($args, $_POST["phone"]);
        }

        $fields.= ")";
        $values.= ")";
        $query.= $fields . $values;
        $res = my_oo_prepared_stmt($link, $query, $types, ...$args);

        if ($res->errno){
            unset($_POST["pass"]);
            unset($_POST["confirm"]);
            // ERROR CODE FOR DUPLICATE KEY

            // questa parte non sta andando
            if ($res->errno === 1062){
                // in register mostrare user già esistente
                unset($_POST["email"]);
            }
            // in register mostrare errore generico
            $_SESSION["registration_POST"] = $_POST;
            header("Location: view_registration.php");
            exit;
        } 
        header("Location: view_login.php");
        exit;
    }
?>

</body>
</html>
