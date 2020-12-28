<?php
    session_start();
    $_SESSION = array();
    setcookie(session_name(), "", 0);
    session_unset();
    session_destroy();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>
<body>
    <script src="js/cart.js"></script>
    <script>
        cartEmpty();
        localStorage.removeItem("username");
        localStorage.removeItem("email");
    </script>
    <meta http-equiv="refresh" content="0.1; url=index.php">
</body>
</html>