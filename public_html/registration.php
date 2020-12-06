
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
    session_start(); 
    require_once("../db_connections/connections.php");
    $link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
    if (isset($_SESSION["email"])){
        header("Location: home.php");
        exit;
    }

    $found = false;
    $abort = false;
    if (isset($_POST['submit'])){

        /* TODO: sistemare segnalazione errori */
        require_once("common/details_reg.php"); 
        if (preg_match($fstname_reg, $_POST["firstname"]) === 0 || !is_valid_length($_POST["firstname"], $min_len["firstname"], $max_len["lastname"])){
            echo "<h1> First name is not valid </h1>"; 
            $abort = true;
        }
        if (preg_match($lastname_reg, $_POST["lastname"]) === 0 || !is_valid_length($_POST["lastname"], $min_len["lastname"], $max_len["lastname"])){
            echo "<h1> Last name is not valid </h1>";
            $abort = true;
        }
        if (preg_match($email_reg, $_POST["email"]) === 0 || !is_valid_length($_POST["email"], $min_len["email"], $max_len["email"])){
            echo "<h1> email is not valid </h1>";
            $abort = true;
        }
        if (preg_match($pass_reg, $_POST["pass"]) === 0 || !is_valid_length($_POST["pass"], $min_len["pass"], $max_len["pass"])){
            echo "<h1> password is not valid </h1>";
            $abort = true;
        } else if ($_POST["pass"] != $_POST["confirm"] || !is_valid_length($_POST["confirm"], $min_len["pass"], $max_len["pass"])){
            echo "<h1> are you sure this is the password that you want? </h1>";
            $abort = true;
        }
        if ($abort){
            header("Location: register.php");
            exit;
        }


        // create user if it doesn't exist
        require_once("common/db_ops.php");
        require_once("common/utilities.php");
        
        // defined in common/db_ops.php
        $email = mysqli_escape_string($link, $_POST["email"]);
        $firstname = mysqli_escape_string($link, $_POST["firstname"]);
        $lastname = mysqli_escape_string($link, $_POST["lastname"]);
        insertuser($link, $email, password_hash($_POST["pass"], PASSWORD_DEFAULT), $firstname, $lastname);  
    }
?>

</body>
</html>
