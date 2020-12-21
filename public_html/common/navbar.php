<?php
    function view_name() {
        return $_SESSION["username"] === NULL
            ? $_SESSION["email"]
            : $_SESSION["username"];
    }
?>

<!--    <li> <a href="allusers.php">All users list</a></li> -->

<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"> <img alt="logo" width="100" src="assets/Jojos.svg"> </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="d-flex justify-content-end collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
      <?php if (isset($_SESSION["email"])){
            if (isset($_SESSION["admin"]) && $_SESSION["admin"] )
                echo "<li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"db_init.php\">DB RESET</a>
                </li>";
            echo "<li class=\"nav-item\">  
            <a class=\"nav-link\" href=\"show_profile.php\"> Ciao " . htmlspecialchars(view_name()) ." </a>".
            "</li>";
        } ?>
        <li class="nav-item">
          <a class="nav-link" href="view_create.php">Crea il tuo design</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="view_designs.php">Design della Community</a>
        </li>
        <?php 
        if (!isset($_SESSION["email"])){
            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"view_login.php\">Accedi</a></li>";
            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"view_registration.php\">Registrati</a></li>";
        }
        else{
          echo "<li class=\"nav-item\"><a class=\"nav-link\" id='cart_btn' href='view_cart.php'>Carrello</a></li>";
            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"logout.php\">Logout</a></li>";
        }
        ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Cart counter JS -->
<script src="js/counter.js"></script>
