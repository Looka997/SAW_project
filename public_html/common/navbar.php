<?php
    function view_name() {
        return $_SESSION["username"] === NULL
            ? $_SESSION["email"]
            : $_SESSION["username"];
    }
?>

<!--    <li> <a href="allusers.php">All users list</a></li> -->

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Inserisci nome del sito qui</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
      <?php if (isset($_SESSION["email"])){
            if (isset($_SESSION["admin"]) && $_SESSION["admin"] )
                echo "<li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"../db_init/db_init.php\">DB RESET</a>
                </li>";
            echo "<li class=\"nav-item\">  
            <a class=\"nav-link\" href=\"show_profile.php\"> Hi " . htmlspecialchars(view_name()) ." </a>".
            "</li>";
        } ?>
        <li class="nav-item">
          <a class="nav-link" href="view_create.php"> Design your own</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="view_designs.php">Designs by the community</a>
        </li>
        <?php 
        if (!isset($_SESSION["email"])){
            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"view_login.php\">Accedi</a></li>";
            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"view_registration.php\">Registrati</a></li>";
        }
        else{
            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"common/logout.php\">Logout</a></li>";
            echo "<li class=\"nav-item\"><a class=\"nav-link\" id='cart_btn' href='cart.php'>Carrello</a></li>";
        }
        ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Cart counter JS -->
<script src="js/counter.js"></script>
