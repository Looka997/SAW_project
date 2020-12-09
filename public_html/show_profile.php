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
        require_once("common/navbar.php");
        require_once("common/db_ops.php");
        require_once("../db_connections/connections.php");
        $link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
        require_once("common/utilities.php");
        require_once("common/details_reg.php");

        // Sempre voluto usare un operatore terziario. Qui ne ho usati due.
        $email = 
                (isset($_GET["email"]) && preg_match($email_reg,$_GET["email"])!=0)? 
                    mysqli_escape_string($link,$_GET["email"]) 
                : 
                    (isset($_SESSION["email"])? 
                        $_SESSION["email"] 
                    : 
                        header("Location: view_login.php") && exit );

        $stmt = user_found($link, $email);
        $res = mysqli_stmt_get_result($stmt);
        if ($res == FALSE){
            echo "mysqli_stmt_get_result failed";
            exit;
        }
        if (mysqli_num_rows($res)== 1){
            $found = TRUE;
            $row = mysqli_fetch_assoc($res);
            // var_dump($row);
            // exit;
        }
        if (!$found){
            // non hai trovato chi cercavi? se sei loggato, cerca te stesso, altrimenti vai a loggarti
            (isset($_SESSION["email"]))? header("Location: show_profile.php") : 
            header("Location: view_login.php");
            exit;
        }
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        if (isset($row["address"]))
            $address = $row["address"];
        if (isset($row["phone"]))
            $phone = $row["phone"];
        mysqli_stmt_close($stmt);
    ?>
    <form action="update_profile.php" method="POST">
        <label for="email">Email:</label>
        <input value="<?php echo htmlspecialchars($email)?>"type="email" id="email" name="email">
        <label for="firstname">First name:</label>
        <input value="<?php echo htmlspecialchars($firstname) ?>"type="text" id="firstname" name="firstname">
        <label for="lastname">Last name:</label>
        <input value="<?php echo htmlspecialchars($lastname) ?>"type="text" id="lastname" name="lastname">
        <label for="address">Address:</label>
        <input value="<?php if (isset($address)) echo htmlspecialchars($address) ?>"type="text" id="address" name="address">
        <label for="phone">Phone:</label>
        <input value="<?php if (isset($phone)) echo htmlspecialchars($phone) ?>"type="text" id="phone" name="phone">
        <input value="<?php echo htmlspecialchars($email) ?>" type="hidden" name="to_update">
        <input type="submit" name="submit" value="submit">
    </form>
</body>
</html>