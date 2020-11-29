
<?php if (isset($_SESSION["email"])) var_dump($_SESSION["email"]);?>
<nav class="navbar">
    <ul>
        <?php 
        if (!isset($_SESSION["email"])){
            echo "<li><a href=\"login.php\">Accedi</a></li>";
            echo "<li><a href=\"registration.php\">Registrati</a></li>";
        }
        else{
            echo "<li> Hi " . $_SESSION["email"] . "</li>"; 
            echo "<li><a href=\"common/logout.php\">Logout</a></li>";
            echo "<li> <a href=\"show_profile.php\">Profilo</a> </li>";
        }
        ?>
        <li> <a href="allusers.php">All users list</a></li>
    </ul>
</nav>
