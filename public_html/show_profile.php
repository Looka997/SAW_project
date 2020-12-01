<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php 
        session_start();
        $found = FALSE;
        if (!isset($_SESSION["email"])){
           header("Location: login.php");
           exit;
        }
        require("common/navbar.php");
        require_once("common/db_ops.php");
        require_once("../db_connections/connections.php");
        $link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
        require_once("common/utilities.php");
        require_once("common/details_reg.php");

        $email = $_SESSION["email"];
        $stmt = user_found($link, $email);
        $res = mysqli_stmt_get_result($stmt);
        if ($res == FALSE){
            echo "mysqli_stmt_get_result failed";
            exit;
        }
        if (mysqli_num_rows($res)== 1){
            $found = TRUE;
            $row = mysqli_fetch_assoc($res);
        }
        if (!$found){
            header("Location: login.php");
            exit;
        }
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        mysqli_stmt_close($stmt);
    ?>
    <form action="show_profile.php" method="POST">
        <label for="email">Email:</label>
        <input value="<?php echo htmlentities($email)?>"type="email" id="email" name="email">
        <label for="firstname">First name:</label>
        <input value="<?php echo htmlentities($firstname) ?>"type="text" id="firstname" name="firstname">
        <label for="lastname">Last name:</label>
        <input value="<?php echo htmlentities($lastname) ?>"type="text" id="lastname" name="lastname">
        <button name="submit" type="submit">Submit</button>
    </form>

    <?php
        $abort = false;
        if (isset($_POST['submit'])){
            if (preg_match($fstname_reg, $_POST["firstname"]) == 0){
                echo "<h1> First name is not valid </h1>";
                $abort = true;
            }
            if (preg_match($lastname_reg, $_POST["lastname"]) == 0){
                echo "<h1> Last name is not valid </h1>";
                $abort = true;
            }
            if (preg_match($email_reg, $_POST["email"])== 0){
                echo "<h1> email is not valid </h1>";
                $abort = true;
            }
            if ($abort){
                header("Location: show_profile.php");
                exit;
            }
            $update_firstname_lastname_email_query = "UPDATE users
                                                        SET firstname = ?, lastname = ?, email = ?
                                                        WHERE email = '$email'";
            $new_mail = mysqli_escape_string($link,$_POST["email"]);
            $new_firstname = mysqli_escape_string($link,$_POST["firstname"]);
            $new_lastname = mysqli_escape_string($link,$_POST["lastname"]);
            $stmt = my_prepared_stmt($link, $update_firstname_lastname_email_query, "sss", $new_firstname, $new_lastname,$new_mail);
            if (mysqli_stmt_affected_rows($stmt)===1){
                mysqli_stmt_close($stmt);
                $_SESSION["email"] = $new_mail;
                var_dump($new_email);
                header("Location: home.php");
                exit;
            }
            mysqli_stmt_close($stmt);
            echo "<h1> Couldn't apply changes </h1>";
        }
    ?>
</body>
</html>