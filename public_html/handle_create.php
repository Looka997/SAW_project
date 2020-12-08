<?php 
    session_start();
    if (!isset($_SESSION["email"])){
        $_SESSION["create_POST"] = $_POST;
        header("Location: logon.php");
        exit;
    }
    require_once("../config/config.php");
    require_once("common/utilities.php");


    // TODO liberare sessione da $_SESSION[create_POST]


    // da fare validazione POST


    // da gestire upload filename
    if(isset($_POST["design_submit"])){

        // TODO: aggiungere error handling (presentare all'utente il perché l'operazione è fallita)
        $uploadOk = 1;
        $input_name = "upload";
        $mime_type = mime_content_type($_FILES[$input_name]["tmp_name"]);
        if (!$mime_type){
            $uploadOk = 0;
        }
        if (!in_array($mime_type, $accepted_mime_types, true)){
            die(var_dump($mime_type));
            $uploadOk = 0;
        }
        $retry = 5;
        do{
            // bisogna riprovare nel caso di collisioni su rand();
            $target_file = UPLOADS_DIR . '/' . $_SESSION["userid"] . rand() . basename($_FILES[$input_name]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $retry -= 1;
        } while($retry > 0 && file_exists($target_file));

        if (!$retry){
            $uploadOk = 0;
        }

        if ($_FILES[$input_name]["size"] > return_bytes(ini_get('upload_max_filesize'))) {
            $uploadOk = 0;
        }

        if(!in_array($imageFileType, $accepted_extensions) ) {
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            header("Location: create.php");
            exit;
        } else {
            if (!move_uploaded_file($_FILES[$input_name]["tmp_name"], $target_file)) {
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