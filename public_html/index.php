<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
  <?php 	
   session_start();	
   require("common/navbar.php");	
   ?> 
  <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div id="index-centered" class="col-md-5 p-lg-5 mx-auto my-5">
      <h1 class="light-txt display-4 fw-normal">Crea il tuo stile!</h1>
      <p class="light-txt lead fw-normal">Vorresti tanto una felpa con il tuo meme preferito, ma non la trovi in vendita? Nessun problema: carica la tua immagine e aspetta che ti arrivi a casa!</p>
      <a class="btn btn-outline-light btn-home" href="view_create.php">Inizia!</a>
    </div>
    <div class="d-flex flex-equal w-100 my-md-3 ps-md-3">
      <div id="community-box" class="w-50 flex-grow-1 bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
        <div class="my-3 py-3">
          <h2 class="light-txt display-5">I design della Community</h2>
          <p class="light-txt lead">Vuoi un regalo originale, ma non hai idee? Esplora i modelli creati dalla community!</p>
          <a class="light-txt btn btn-home btn-outline-secondary" href="view_designs.php">Vai ai designs</a>
        </div>
      </div>

      <div id="about-us-box" class="w-50 flex-grow-1 bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
        <div class="my-3 py-3">
          <h2 class="light-txt display-5">Chi siamo</h2>
          <p class="light-txt lead">Luca, Federico e Alessio</p>
        </div>
      </div>

      <div id="help-box" class="w-50 flex-grow-1 bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
        <div class="my-3 py-3">
          <h2 class="light-txt display-5">Bisogno di aiuto?</h2>
          <p class="light-txt lead">Contattaci!</p>
          <a class="dark-txt btn-home btn btn-outline-secondary" href="view_designs.php">Vai ai contatti</a>
        </div>
      </div>
    </div>
  </div>

  <?php
  require("common/footer.php");
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>
