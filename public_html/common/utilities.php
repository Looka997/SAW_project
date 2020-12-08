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

    function return_bytes ($size_str)
    {
        switch (substr ($size_str, -1))
        {
            case 'M': case 'm': return (int)$size_str * 1048576;
            case 'K': case 'k': return (int)$size_str * 1024;
            case 'G': case 'g': return (int)$size_str * 1073741824;
            default: return $size_str;
        }
    }

?>