
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign-up</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require("common/navbar.php") ?>


    <form action="registration.php" method="POST" id="registerForm">
            <label for="firstname">First name:</label>
            <input type="text" id="firstname" name="firstname">
            <label for="lastname">Last name:</label>
            <input type="text" id="lastname" name="lastname">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
            <label for="pass">Password:</label>
            <input type="password" id="pass" name="pass">
            <label for="confirm">Confirm password:</label>
            <input type="password" id="confirm" name="confirm">
            <input type="submit" name="submit" value="submit">
    </form>

    <?php require_once("common/footer.php"); ?>

</body>
</html>
