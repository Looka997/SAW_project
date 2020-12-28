<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="favicon.png" type="image/png">
</head>

<body>
    <?php
    session_start();
    $found = FALSE;
    require_once("common/navbar.php");
    require_once("common/db_ops.php");
    require_once("common/get_keywords.php");
    require_once("../db_connections/connections.php");
    $link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
    require_once("common/utilities.php");
    require_once("common/details_reg.php");

    // $email = 
    //         (isset($_GET["email"]) && preg_match($email_reg,$_GET["email"])!=0)? 
    //             mysqli_escape_string($link,$_GET["email"]) 
    //         : 
    //             (isset($_SESSION["email"])? 
    //                 $_SESSION["email"] 
    //             : 
    //                 header("Location: view_login.php") && exit );

    // the username GET parameter gets passed from the links to the user profile.
    $param = "";
    if (isset($_GET[EMAIL]) && preg_match($email_reg, $_GET[EMAIL]) != 0) {
        // The email search is kept for legacy reasons (and because the username is not mandatory)
        $param = $_GET[EMAIL];
    } else if (isset($_GET[USERNAME])) {
        $param = $_GET[USERNAME];
    } else if (isset($_SESSION["email"])) {
        $param = $_SESSION["email"];
    } else {
        header("Location: view_login.php");
        exit;
    }

    // This uses a prepared statement
    $stmt = user_from_email_username($link, $param);
    if ($stmt->errno) {
        header("Location: view_login.php");
        exit;
    }
    $res = mysqli_stmt_get_result($stmt);
    if ($res === FALSE) {
        header("Location: view_login.php");
        exit;
    }
    if (mysqli_num_rows($res) === 1) {
        $found = TRUE;
        $row = mysqli_fetch_assoc($res);
    }
    if (!$found) {
        // In case of an invalid email, send the user to either
        // their own profile if they're logged in or to the login
        // page in case they aren't logged in
        (isset($_SESSION["email"]))
            ? header("Location: show_profile.php")
            : header("Location: view_login.php");
        exit;
    }

    $email = $row["email"];
    $id = $row["id"];
    $firstname = $row["firstname"];
    $lastname = $row["lastname"];
    if (isset($row["address"]))
        $address = $row["address"];
    if (isset($row["phone"]))
        $phone = $row["phone"];
    if (isset($row["username"]))
        $username = $row["username"];
    mysqli_stmt_close($stmt);
    ?>
    <form action="update_profile.php" method="POST">
        <div class="container" id="profile">
            <div class="row">
                <h2>Account</h2>
                <label for="email">Email:</label><br>
                <input value="<?php echo htmlspecialchars($email) ?>" type="email" id="email" name="email">
                <br>
                <label for="firstname">First name:</label><br>
                <input value="<?php echo htmlspecialchars($firstname) ?>" type="text" id="firstname" name="firstname">
                <br>
                <label for="lastname">Last name:</label><br>
                <input value="<?php echo htmlspecialchars($lastname) ?>" type="text" id="lastname" name="lastname">
                <br>
                <label for="address">Address:</label><br>
                <input value="<?php if (isset($address)) echo htmlspecialchars($address) ?>" type="text" id="address" name="address">
                <br>
                <label for="phone">Phone:</label><br>
                <input value="<?php if (isset($phone)) echo htmlspecialchars($phone) ?>" type="text" id="phone" name="phone">
                <br>
                <label for="username">Username:</label><br>
                <input value="<?php if (isset($username)) echo htmlspecialchars($username) ?>" type="text" id="username" name="username">
            </div>
        </div>
        <?php
        if (strcmp($email, $_SESSION['email']) === 0 && $_SESSION["username"] === NULL) {
            echo '<p>For a better experience, set a username!</p>';
        }
        ?>

        <?php if (strcmp($email, $_SESSION['email']) === 0) : ?>
            <div class="profile-btn col-xs-12 divider text-center">
                <input value="<?php echo htmlspecialchars($email) ?>" type="hidden" name="to_update">
                <button class="btn btn-success btn-block" type="submit" name="submit" value="submit"> Submit </button>
            </div>
        <?php endif; ?>
    </form>
    <?php if (isset($_GET["username"]) || isset($_GET["email"])) { ?>
        <form action="follow.php" method="POST">
        <div class="profile-btn col-xs-12 divider text-center">
                <p>Clicca "Segui" per rimanere aggiornato sui nuovi designs!</p>
            <button class="btn btn-success btn-block" type="submit" name="segui" value="Segui"><span class="follow fa fa-plus-circle"></span> Segui </button>
            <input type="hidden" name="redirect" value="<?php if (isset($email)) echo htmlspecialchars($email) ?>">
        </div>
        </form>
    <?php } ?>
    <?php
    require("common/footer.php");
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>