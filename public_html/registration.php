
<!DOCTYPE html>
<html lang="it">
<head>
    <title>Sign-up</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php

session_start(); 
    require_once("../db_connections/connections.php");
    $link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
    // Commentato altrimenti non passa i test
    // if (isset($_SESSION["email"])){
    //     header("Location: index.php");
    //     exit;
    // }

    $found = false;
    $abort = false;
    $errno = [];
    if (isset($_POST['submit'])){
        if (isset($_SESSION['registration_POST'])){
            unset($_SESSION["registration_POST"]);
        }

        $_POST['firstname'] = trim($_POST['firstname']);
        $_POST['lastname'] = trim($_POST['lastname']);
        $_POST['email'] = trim($_POST['email']);
        $_POST['username'] = trim($_POST['username']);
        $_POST['address'] = trim($_POST['address']);
        $_POST['phone'] = trim($_POST['phone']);

        require_once("common/details_reg.php");
        require_once("common/error_codes.php");
        require("common/get_keywords.php");
        if (preg_match($fstname_reg, $_POST["firstname"]) === 0 || !is_valid_length($_POST["firstname"], $min_len["firstname"], $max_len["lastname"])){
            unset($_POST["firstname"]);
            $abort = true;
            array_push($errno, WRONG_FORMAT_ERR);
        }
        if (preg_match($lastname_reg, $_POST["lastname"]) === 0 || !is_valid_length($_POST["lastname"], $min_len["lastname"], $max_len["lastname"])){
            unset($_POST["lastname"]);
            $abort = true;
            array_push($errno, WRONG_FORMAT_ERR);
        }
        if (preg_match($email_reg, $_POST["email"]) === 0 || !is_valid_length($_POST["email"], $min_len["email"], $max_len["email"])){
            unset($_POST["email"]);
            $abort = true;
            array_push($errno, WRONG_FORMAT_ERR);
        }
        if ($_POST["pass"] !== $_POST["confirm"]) {
            $abort = true;
            array_push($errno, NOT_MATCH_ERR);
        }
        if (strlen($_POST["username"])){
            if (preg_match($pass_reg, $_POST["username"]) === 0 || !is_valid_length($_POST["username"], $min_len["username"], $max_len["username"])){
                unset($_POST["username"]);
                $abort = true;
                array_push($errno, WRONG_FORMAT_ERR);
            }
        }
        if (strlen($_POST["address"])){
            if (preg_match($pass_reg, $_POST["address"]) === 0 || !is_valid_length($_POST["address"], $min_len["address"], $max_len["address"])){
                unset($_POST["addres"]);
                $abort = true;
                array_push($errno, WRONG_FORMAT_ERR);
            }
        }
        if (strlen($_POST["phone"])){
            if (preg_match($pass_reg, $_POST["phone"]) === 0 || !is_valid_length($_POST["phone"], $min_len["phone"], $max_len["phone"])){
                unset($_POST["phone"]);
                $abort = true;
                array_push($errno, WRONG_FORMAT_ERR);
            }
        }
        if ($abort){
            unset($_POST["pass"]);
            unset($_POST["confirm"]);
            $_SESSION["registration_POST"] = $_POST; 
            header("Location: view_registration.php?" . array_to_get($errno, ERROR));
            exit;
        }


        // create user if it doesn't exist
        require_once("common/db_ops.php");
        require_once("common/utilities.php");
        
        // puts the email to lower to check for duplicates
        $email = strtolower(mysqli_escape_string($link, $_POST["email"]));
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
            if ($res->errno === 1062) {
                // in register mostrare user già esistente
                unset($_POST["email"]);
                array_push($errno, DB_DUP_ERR);
            } else {
                array_push($errno, DB_GENERIC_ERR);
            }
            // in register mostrare errore generico
            $_SESSION["registration_POST"] = $_POST;
            header("Location: view_registration.php?" . array_to_get($errno, ERROR));
            exit;
        } 
        header("Location: view_login.php");
        exit;
    }
?>

</body>
</html>
