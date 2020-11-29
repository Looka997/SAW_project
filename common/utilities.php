<?php
    require_once("db_ops.php");

    $insert_user_query = "INSERT into users (email, password, firstname, lastname) VALUES (?, ?, ?, ?)";
    $search_user_by_mail_query = "SELECT * from users
                                    WHERE email = ?";
    

    function user_found($link, $email){
        global $search_user_by_mail_query;
        $stmt = my_oo_prepared_stmt($link, $search_user_by_mail_query, "s", $email);
        return $stmt;
    }

    function insertuser($link, $email, $password, $firstname, $lastname){
        global $insert_user_query;
        $stmt = my_oo_prepared_stmt($link, $insert_user_query, "ssss", $email, $password, $firstname, $lastname);
        return $stmt;
    }

?>