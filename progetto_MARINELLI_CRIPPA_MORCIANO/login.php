<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        require("common/navbar.php");
        ?>

    <form action="login.php" method="post" id="loginForm">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <label for="pass">Password:</label>
        <input type="password" id="pass" name="pass">
        <input type="submit" name="submit" value="submit">
    </form>

    <?php 
        if (isset($_POST['submit'])){
            require_once("common/db_ops.php");
            require_once("common/utilities.php");
            $found = FALSE;
            // defined in common/db_ops.php
          
            $email = mysqli_escape_string($link, $_POST["email"]);
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
            if ($found && (password_verify($_POST["pass"], $row["password"]))){
                $_SESSION["email"] = $email;
                mysqli_stmt_close($stmt);
                header('Location: home.php');
                exit;
            }
            else{
                echo "<h1> User not found </h1>" ; 
                mysqli_stmt_close($stmt);
            }
        }  
        require_once("common/footer.php");
    ?>
</body>
</html>