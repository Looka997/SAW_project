<?php 
    session_start();
    if (!isset($_SESSION["email"])){
        $_SESSION["create_POST"] = $_POST;
        header("Location: logon.php");
        exit;
    }
    require_once("../config/config.php");
    require_once("common/utilities.php");
    require_once("common/details_reg.php");


    // TODO liberare sessione da $_SESSION[create_POST]

    unset($_SESSION["create_POST"]);

    // validazione POST e gestire upload filename
    if(isset($_POST["design_submit"])){
        
        $abort = false;
        if (preg_match($design_name, $_POST["design_name"])===0){
            $abort = true;
        }
        if (!in_array($_POST["model"],$_POST["model_names"],true)){
            $abort = true;
        }
        if (preg_match($design_price_reg, $_POST["design_price"])===0){
            $abort = true;
        }

        // TODO: aggiungere error handling (presentare all'utente il perché l'operazione è fallita)
        $input_name = "upload";
        $mime_type = mime_content_type($_FILES[$input_name]["tmp_name"]);
        if (!$mime_type){
            $abort = true;
        }
        if (!in_array($mime_type, $accepted_mime_types, true)){
            $abort = true;
        }
        $retry = 5;
        do{
            // bisogna riprovare nel caso di collisioni su rand();
            $target_file = UPLOADS_DIR . '/' . $_SESSION["userid"] . rand() . basename($_FILES[$input_name]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $retry -= 1;
        } while($retry > 0 && file_exists($target_file));

        if (!$retry){
            $abort = true;
        }

        if ($_FILES[$input_name]["size"] > return_bytes(ini_get('upload_max_filesize'))) {
            $abort = true;
        }

        if(!in_array($imageFileType, $accepted_extensions, true)) {
            $abort = true;
        }

        if ($abort) {
            header("Location: create.php");
            exit;
        } else {
            if (!move_uploaded_file($_FILES[$input_name]["tmp_name"], $target_file)) {
                // qua deve inserire su db
                header("Location: create.php");
                exit;
            }
        }
    }

    //only for testing, to remove later
    $_SESSION["create_POST"] = $_POST;
    header("Location: create.php");
    //

?>