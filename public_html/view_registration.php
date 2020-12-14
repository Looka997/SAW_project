
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
        require("common/navbar.php")
    ?>
<?php 
    if (isset($_SESSION["registration_POST"])){
        $restoring = array_map('htmlspecialchars',$_SESSION["registration_POST"]);
    }
?>
<section>
    <form action="registration.php" method="POST" id="registerForm">
                <label for="firstname">*First name:</label>
                <input type="text" id="firstname" name="firstname" value="<?php if (isset($restoring) && isset($restoring['firstname'])) echo $restoring["firstname"] ?>">
                <label for="lastname">*Last name:</label>
                <input type="text" id="lastname" name="lastname" value="<?php if (isset($restoring) && isset($restoring['lastname'])) echo $restoring["lastname"] ?>">
                <label for="email">*Email</label>
                <input type="email" id="email" name="email" value="<?php if (isset($restoring) && isset($restoring['email'])) echo $restoring["email"] ?>">
                <label for="pass">*Password:</label>
                <input type="password" id="pass" name="pass">
                <label for="confirm">*Confirm password:</label>
                <input type="password" id="confirm" name="confirm">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php if (isset($restoring) && isset($restoring['username'])) echo $restoring["username"] ?>">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php if (isset($restoring) && isset($restoring['address'])) echo $restoring["address"] ?>">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php if (isset($restoring) && isset($restoring['phone'])) echo $restoring["phone"] ?>">
                <input type="submit" name="submit" value="submit">
    </form>
    <p>Fields marked by * are mandatory</p>
</section>
    


    <?php require_once("common/footer.php"); ?>

</body>
</html>
