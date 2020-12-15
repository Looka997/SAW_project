<?php 
    session_start();
    require_once("../db_connections/connections.php");
    require_once("common/db_ops.php");
    require_once("common/error_codes.php");
    $link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
    if (!isset($_SESSION["email"])){
        $_SESSION["create_POST"] = $_POST;
        header("Location: view_login.php");
        exit;
    }
    require_once("../config/config.php");
    require_once("common/utilities.php");
    require_once("common/details_reg.php");


    // TODO liberare sessione da $_SESSION[create_POST]

    unset($_SESSION["create_POST"]);

    // validazione POST e gestire upload filename
    if(isset($_POST["design_submit"])){
        $errno = -1;
        
        if (!(isset($_POST["design_name"]) && isset($_POST["model"]) && isset($_POST["design_price"]))){
            $abort = true;
            $errno = NOT_SET_ERR;
        }

        $abort = false;
        if (preg_match($design_name_reg, $_POST["design_name"])===0){
            $abort = true;
            $errno = WRONG_FORMAT_ERR;
        }
        if (!in_array($_POST["model"],$_SESSION["model_names"],true)){
            $abort = true;
            $errno = WRONG_FORMAT_ERR;
        }
        if (preg_match($design_price_reg, $_POST["design_price"])===0){
            $abort = true;
            $errno = WRONG_FORMAT_ERR;
        }

        // TODO: aggiungere error handling (presentare all'utente il perché l'operazione è fallita)
        $input_name = "upload";
        $mime_type = mime_content_type($_FILES[$input_name]["tmp_name"]);
        if (!$mime_type){
            $abort = true;
            $errno = WRONG_MIME_ERR;
        }
        if (!in_array($mime_type, $accepted_mime_types, true)){
            $abort = true;
            $errno = WRONG_MIME_ERR;
        }
        $retry = 5;
        do{
            // bisogna riprovare nel caso di collisioni su rand();
            $random_num = rand();
            $target_file = UPLOADS_DIR . '/' . $_SESSION["userid"] . $random_num . basename($_FILES[$input_name]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $retry -= 1;
        } while($retry > 0 && file_exists($target_file));

        if (!$retry){
            $abort = true;
            $errno = GENERIC_ERR;
        }

        if ($_FILES[$input_name]["size"] > return_bytes(ini_get('upload_max_filesize'))) {
            $abort = true;
            $errno = SIZE_ERR;
        }

        if(!in_array($imageFileType, $accepted_extensions, true)) {
            $abort = true;
            $errno = WRONG_MIME_ERR;
        }

        if ($abort) {
            header("Location: view_create.php?error=" . $errno);
            exit;
        } else {
            if (!move_uploaded_file($_FILES[$input_name]["tmp_name"], $target_file)) {
                $errno = GENERIC_ERR;
                header("Location: view_create.php?error=" . $errno);
                exit;
            }
            // qua deve inserire su db
            $query = "INSERT INTO products (name, model, author, filename, price) VALUES 
            (?,?,?,?,?)";
            $res = my_oo_prepared_stmt($link,
                $query,
                "ssisd",
                $_POST["design_name"],
                $_POST["model"],
                $_SESSION["userid"],
                basename($target_file),
                $_POST["design_price"]);
            
            if ($res->errno){
                header("Location: view_create.php?error=" . DB_GENERIC_ERR);
                exit;
            }
        }
    }

    //TODO: only for testing, to remove later
    header("Location: view_designs.php");

?>