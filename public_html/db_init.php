<?php
    session_start();
    if (!isset($_SESSION['admin'])) {
        http_response_code(403);
        exit;
    }
    if (!$_SESSION['admin']) {
        http_response_code(403);
        exit;
    }

    include("../db_init/db_init.php");
