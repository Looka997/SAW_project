
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
        require("common/navbar.php");
        require_once("common/details_reg.php");

        if (isset($_SESSION["registration_POST"])){
            $restoring = array_map('htmlspecialchars',$_SESSION["registration_POST"]);
        }

        if (isset($_GET["error"])) {
            require_once("common/error_codes.php");

            $error = "";
            // Using format to allow for faster edits in case of adding classes or ids
            $format = "<p>%s</p>";
            switch ($_GET['error']) {
                case DB_DUP_ERR:
                    $error = sprintf($format, "Email or Username already in use.");
                    break;
                case DB_GENERIC_ERR:
                case GENERIC_ERR:
                    $error = sprintf($format, "An error has occured.");
                    break;
                case WRONG_FORMAT_ERR:
                    $error = sprintf($format, "Something was spelled wrong or the format doesn't respect what we expect.");
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
<section>
    <form action="registration.php" method="POST" id="registerForm">
                <label for="firstname">*First name:</label>
                <input
                    type="text"
                    id="firstname"
                    name="firstname"
                    value="<?php if (isset($restoring) && isset($restoring['firstname'])) echo $restoring["firstname"] ?>"
                    pattern="<?php echo preg_replace("/\//", "", $fstname_reg) ?>">

                <label for="lastname">*Last name:</label>
                <input
                    type="text"
                    id="lastname"
                    name="lastname"
                    value="<?php if (isset($restoring) && isset($restoring['lastname'])) echo $restoring["lastname"] ?>"
                    pattern="<?php echo preg_replace("/\//", "", $lastname_reg) ?>">
                
                <label for="email">*Email</label>
                <input type="email" id="email" name="email" value="<?php if (isset($restoring) && isset($restoring['email'])) echo $restoring["email"] ?>">

                <label for="pass">*Password:</label>
                <input type="password" id="pass" name="pass">

                <label for="confirm">*Confirm password:</label>
                <input type="password" id="confirm" name="confirm">

                <label for="username">Username:</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="<?php if (isset($restoring) && isset($restoring['username'])) echo $restoring["username"] ?>"
                    pattern="<?php echo preg_replace("/\//", "", $username_reg) ?>">

                <label for="address">Address:</label>
                <input
                    type="text"
                    id="address"
                    name="address"
                    value="<?php if (isset($restoring) && isset($restoring['address'])) echo $restoring["address"] ?>"
                    pattern="<?php echo preg_replace("/\//", "", $address_reg) ?>">

                <label for="phone">Phone:</label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="<?php if (isset($restoring) && isset($restoring['phone'])) echo $restoring["phone"] ?>"
                    pattern="<?php echo preg_replace("/\//", "", $phone_reg) ?>">

                <input type="submit" name="submit" value="submit">
    </form>
    <p>Fields marked by * are mandatory</p>
</section>
    


    <?php require_once("common/footer.php"); ?>

</body>
</html>
