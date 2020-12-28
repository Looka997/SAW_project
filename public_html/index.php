<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="css/my-bootstrap-ext.css" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="shortcut icon" href="favicon.png" type="image/png">
</head>
<body>
  <?php 	
   session_start();	
   require("common/navbar.php");	
   ?> 
  <div class="position-relative overflow-hidden text-center" id="home">
    <div id="index-centered" class="jumbotron jumbotron-fluid">
      <h1 class="light-txt display-4 fw-normal">Crea il tuo stile!</h1>
      <p class="light-txt lead fw-normal">Vorresti tanto una felpa con il tuo meme preferito, ma non la trovi in vendita? Nessun problema: carica la tua immagine e aspetta che ti arrivi a casa!</p>
      <a class="btn btn-outline-light btn-home" href="view_create.php">Inizia!</a>
    </div>

    <div id="info-box-container" class="d-flex flex-wrap flex-lg-nowrap ">
      <div class="info-box w-100 w-lg-33 mw-lg-33 w-xl-25">
        <div>
          <img class="info-icon" src="assets/Leaf_font_awesome.svg" alt="leaf">
        </div>
        <span class="info-title">
          Prodotti con Zero emissioni CO2
        </span>
        <span class="info-desc">
          Garantiti dalla IEEE
        </span>
      </div>

      <div class="info-box w-100 w-lg-33 mw-lg-33 w-xl-25">
        <div>
          <img class="info-icon" src="assets/Money_font_awesome.svg" alt="leaf">
        </div>
        <span class="info-title">
          Supporta i tuoi artisti preferiti
        </span>
        <span class="info-desc">
          il 5% del ricavato andrà all'artista (tasse escluse)
        </span>
      </div>

      <div class="info-box w-100 w-lg-33 mw-lg-33 w-xl-25">
        <div>
          <img class="info-icon" src="assets/Font_Awesome_5_solid_truck.svg" alt="leaf">
        </div>
        <span class="info-title">
          Spedizione entro Natale
        </span>
        <span class="info-desc">
          Consegna garantita
        </span>
      </div>
    </div>


    <div class="d-flex flex-wrap flex-lg-nowrap w-100 my-md-3">
      <div id="community-box" class="mx-lg-2 w-100 w-md-50 flex-grow-1 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden index-images">
        <div class="my-3 py-3">
          <h2 class="light-txt display-5">I design della Community</h2>
          <p class="light-txt lead">Vuoi un regalo originale, ma non hai idee? Esplora i modelli creati dalla community!</p>
          <a class="light-txt btn btn-home btn-outline-secondary" href="view_designs.php">Vai ai designs</a>
        </div>
      </div>

      <div id="about-us-box" class="mx-lg-2 w-100 w-md-50 flex-grow-1 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden index-images">
        <div class="my-3 py-3">
          <h2 class="light-txt display-5">Chi siamo</h2>
          <p class="light-txt lead">Luca, Federico e Alessio</p>
        </div>
      </div>

      <div id="help-box" class="mx-lg-2 w-100 w-md-50 flex-grow-1 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden index-images">
        <div class="my-3 py-3">
          <h2 class="light-txt display-5">Bisogno di aiuto?</h2>
          <p class="light-txt lead">Contattaci!</p>
          <a class="dark-txt btn-home btn btn-outline-secondary" href="http://localhost/SAW/SAW_project/public_html/not-found.php">Vai ai contatti</a>
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
