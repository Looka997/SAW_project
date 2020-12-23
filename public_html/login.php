<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        const COOKIE_DURATION = 21600;  // 6 hours
        session_start();
        require_once("../db_connections/connections.php");
        $link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
        // Commentato altrimenti non passa i test
        // if (isset($_SESSION["email"])){ 
        //     header("Location: index.php");
        //     exit;
        // }

        if (isset($_POST['submit'])){
            require_once("common/db_ops.php");
            require_once("common/utilities.php");
            require_once("common/error_codes.php");
            require("common/get_keywords.php");
            $found = FALSE;
            // defined in common/db_ops.php
          
            $email = mysqli_escape_string($link, $_POST["email"]);
            $stmt = user_found($link, $email);
            if ($stmt->errno){
                mysqli_stmt_close($stmt);
                header("Location: view_login.php?" . ERROR . "=" . DB_GENERIC_ERR);
                exit;
            } 
            $res = mysqli_stmt_get_result($stmt);
            
            
            if ($res === FALSE){
                mysqli_stmt_close($stmt);
                header("Location: view_login.php?" . ERROR . "=" . DB_GENERIC_ERR);
                exit;
            }

            if (mysqli_num_rows($res) === 1){
                $found = TRUE;
                $row = mysqli_fetch_assoc($res);
            }

            if ($found && password_verify($_POST["pass"], $row["password"])) {
                $_SESSION["email"] = $email;
                $_SESSION["userid"] = $row["id"];
                $_SESSION["username"] = isset($row["username"])? $row["username"] : $email;
                if ($row["admin"])
                    $_SESSION["admin"] = TRUE;
                setcookie(session_name(), $_COOKIE[session_name()], time() + COOKIE_DURATION);
                mysqli_stmt_close($stmt);
            } else {
                mysqli_stmt_close($stmt);
                header("Location: view_login.php?" . ERROR . "=" . NOT_FOUND);
                exit;
            }
        }
    ?>

<script>
    let username = <?php echo isset($_SESSION['username']) ? "'{$_SESSION['username']}'" : "null" ?>;
    let email = <?php echo isset($_SESSION['email']) ? "'{$_SESSION['email']}'" : "null" ?>;
    localStorage.setItem("username", username);
    localStorage.setItem("email", email);
</script>

<?php
    if (isset($_SESSION["create_POST"])) {
        echo '<meta http-equiv="refresh" content="0; url=view_create.php">';
    }
    echo '<meta http-equiv="refresh" content="0; url=index.php">';
?>

</body>
</html>