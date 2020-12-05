
<nav class="navbar">
    <ul>
        <?php if (isset($_SESSION["email"])){
            if (isset($_SESSION["admin"]) && $_SESSION["admin"] )
                echo "<li><a href=\"../db_init/db_init.php\">DB RESET</a></li>";
            echo "<li> Hi " . htmlspecialchars($_SESSION["email"]) . " </li>";
        } ?>
        <li>
            <a href="show_products.php">I prodotti della community</a>
        </li>
        <?php 
        if (!isset($_SESSION["email"])){
            echo "<li><a href=\"login.php\">Accedi</a></li>";
            echo "<li><a href=\"registration.php\">Registrati</a></li>";
        }
        else{
            echo "<li><a href=\"common/logout.php\">Logout</a></li>";
            echo "<li> <a href=\"show_profile.php\">Profilo</a> </li>";
        }
        ?>
        <li> <a href="allusers.php">All users list</a></li>
    </ul>
</nav>
