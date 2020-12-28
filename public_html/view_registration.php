
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registrati</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/signin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="favicon.png" type="image/png">
</head>

<body>
    <?php 
        session_start();
        if (isset($_SESSION["email"])){
            header("Location: index.php");
            exit;
        }
        require("common/navbar.php");
        require_once("common/details_reg.php");
        require("common/get_keywords.php");

        if (isset($_SESSION["registration_POST"])){
            $restoring = array_map('htmlspecialchars',$_SESSION["registration_POST"]);
        }

        if (isset($_GET[ERROR])) {
            require_once("common/error_codes.php");


            $error = "";
            // Using format to allow for faster edits in case of adding classes or ids
            $format = "<p>%s</p>";
            foreach ($_GET[ERROR] as $errno) {
                switch ($errno) {
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
                    case NOT_MATCH_ERR:
                        $error = sprintf($format, "Password didn't match.");
                        break;
                    default:
                        $error = sprintf($format, "An unexpected error has occured.");
                }

                echo $error;
            }
        }
    ?>
<div class="text-center">
<main class="form-signin">
    <form id="registerForm" action="registration.php" method="POST">
    <h1 class="h3 mb-3 fw-normal">Registrati</h1>
                <label for="firstname" class="visually-hidden">*Nome:</label>
                <input
                    class="form-control"
                    placeholder="Nome"
                    required=""
                    type="text"
                    id="firstname"
                    name="firstname"
                    value="<?php if (isset($restoring) && isset($restoring['firstname'])) echo $restoring["firstname"] ?>"
                    pattern="<?php echo substr($fstname_reg, 1, strlen($fstname_reg) - 2) ?>">

                <label for="lastname" class="visually-hidden">*Cognome:</label>
                <input
                    class="form-control"
                    placeholder="Cognome"
                    required=""
                    type="text"
                    id="lastname"
                    name="lastname"
                    value="<?php if (isset($restoring) && isset($restoring['lastname'])) echo $restoring["lastname"] ?>"
                    pattern="<?php echo substr($lastname_reg, 1, strlen($lastname_reg) - 2) ?>">
                
                <label for="email"  class="visually-hidden">*Email</label>
                <input class="form-control" placeholder="Email" required="" type="email" id="email" name="email" value="<?php if (isset($restoring) && isset($restoring['email'])) echo $restoring["email"] ?>">

                <label for="pass" class="visually-hidden">*Password:</label>
                <input class="form-control" placeholder="Password" required="" type="password" id="pass" name="pass">

                <label for="confirm" class="visually-hidden">*Conferma password:</label>
                <input class="form-control" placeholder="Conferma password" required="" type="password" id="confirm" name="confirm">

                <label for="username" class="visually-hidden">Username:</label>
                <input
                   class="form-control"
                    placeholder="Username"
                    type="text"
                    id="username"
                    name="username"
                    value="<?php if (isset($restoring) && isset($restoring['username'])) echo $restoring["username"] ?>"
                    pattern="<?php echo substr($username_reg, 1, strlen($username_reg) - 2) ?>">

                <label for="address" class="visually-hidden">Indirizzo:</label>
                <input
                class="form-control"
                    placeholder="Indirizzo"
                    type="text"
                    id="address"
                    name="address"
                    value="<?php if (isset($restoring) && isset($restoring['address'])) echo $restoring["address"] ?>"
                    pattern="<?php echo substr($address_reg, 1, strlen($address_reg) - 2) ?>">

                <label for="phone" class="visually-hidden">Telefono:</label>
                <input
                class="form-control"
                    placeholder="Telefono"
                    type="text"
                    id="phone"
                    name="phone"
                    value="<?php if (isset($restoring) && isset($restoring['phone'])) echo $restoring["phone"] ?>"
                    pattern="<?php echo substr($phone_reg, 1, strlen($phone_reg) - 2) ?>">

                    <button id="submit" class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Registrati</button>
    </form>
    <p id="txt_obbl">I campi * sono obbligatori</p>
</main>
</div>
    


    <?php require_once("common/footer.php"); ?><
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>  

    <script src="js/user_check.js"></script>
</body>
</html>




 
   
    



