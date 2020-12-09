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