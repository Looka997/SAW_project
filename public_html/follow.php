<?php
session_start();
require_once("common/db_ops.php");
require_once("../db_connections/connections.php");
$link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);

$query = "INSERT INTO mail_list (email_follower, email_creator) VALUES (?,?)";
$types = "ss";
$stmt = my_oo_prepared_stmt($link, $query, $types, $_SESSION["email"], $_POST["redirect"]); 

header("Location: show_profile.php?email=".$_POST["redirect"]);
exit;


?>
<!--
    1. Creare tabella DB INIT (2 chiavi esterne e primarie su entrambe le colonne. Sono gli ID degli utenti che seguono [1^ colonna] e sono seguiti [2^colonna]).
    2. Tasto "follow": c'è una variabile $_SESSION["userid"]=> id utente.
    3. Trovare un modo per prendere l'id di quello CHE VUOLE SEGUIRE.
    4. Una volta inseriti nella tabella, ogni volta che qualcuno iserisce un design, modifico la pagina "create.php" che faccia una query e mandare una mail che followano. 
    5. TASTO FOLLOW, NON E' CAMPO DEL FORM IN SHOW_PRROFILE MA UN FORM NUOVO, SOTTO A QUELLO ESITENTE
-->


