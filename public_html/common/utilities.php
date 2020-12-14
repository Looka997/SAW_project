<?php
    require_once("db_ops.php");

    $search_user_by_mail_query = "SELECT * from users
                                    WHERE email = ?";
    

    function user_found($link, $email){
        global $search_user_by_mail_query;
        return my_oo_prepared_stmt($link, $search_user_by_mail_query, "s", $email);
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