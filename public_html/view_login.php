<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        session_start();
        require("common/navbar.php");
        require("common/get_keywords.php");

        if (isset($_GET[ERROR])) {
            require_once("common/error_codes.php");

            $error = "";
            // Using format to allow for faster edits in case of adding classes or ids
            $format = "<p>%s</p>";
            switch ($_GET[ERROR]) {
                case NOT_FOUND:
                    $error = sprintf($format, "User not found.");
                    break;
                case DB_GENERIC_ERR:
                case GENERIC_ERR:
                    $error = sprintf($format, "An error has occured.");
                    break;
                case NOT_SET_ERR:
                    $error = sprintf($format, "Something wasn't set correctly.");
                    break;
                default:
                    $error = sprintf($format, "An unexpected error has occured.");
            }

            echo $error;
        }
    ?>

    <form action="login.php" method="post" id="loginForm">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <label for="pass">Password:</label>
        <input type="password" id="pass" name="pass">
        <input type="submit" name="submit" value="submit">
    </form>

    <?php require_once("common/footer.php"); ?>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>  

</body>
</html>