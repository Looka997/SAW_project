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
        require("common/navbar.php");

        if (isset($_GET["error"])) {
            require_once("common/error_codes.php");

            $error = "";
            // Using format to allow for faster edits in case of adding classes or ids
            $format = "<p>%s</p>";
            switch ($_GET['error']) {
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
</body>
</html>