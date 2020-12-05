<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <?php 
   session_start();
   if (!isset($_SESSION["email"])){
        header("Location: login.php");
        exit;
   }
   require("common/navbar.php");
   ?> 
</body>
</html>