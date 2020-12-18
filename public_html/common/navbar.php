<?php
    function view_name() {
        return $_SESSION["username"] === NULL
            ? $_SESSION["email"]
            : $_SESSION["username"];
    }
?>

<nav class="navbar">
    <ul>
        <?php if (isset($_SESSION["email"])){
            if (isset($_SESSION["admin"]) && $_SESSION["admin"] )
                echo "<li><a href=\"../db_init/db_init.php\">DB RESET</a></li>";
            echo "<li> Hi " . htmlspecialchars(view_name()) . " </li>";
        } ?>
        <li><a href="view_create.php"> Design your own </a></li>
        <li><a href="view_designs.php">Designs by the community</a></li>
        <?php 
        if (!isset($_SESSION["email"])){
            echo "<li><a href=\"view_login.php\">Accedi</a></li>";
            echo "<li><a href=\"view_registration.php\">Registrati</a></li>";
        }
        else{
            echo "<li><a href=\"common/logout.php\">Logout</a></li>";
            echo "<li><a href=\"show_profile.php\">Profilo</a></li>";
            echo "<li id='cart_btn'><a href='cart.php'>Carrello</a></li>";
        }
        ?>
        <li> <a href="allusers.php">All users list</a></li>
    </ul>
</nav>

<!-- Cart counter JS -->
<script src="js/counter.js"></script>
