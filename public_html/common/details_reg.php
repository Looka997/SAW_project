<?php 
    $fstname_reg = '/.+/';
    $lastname_reg = '/.+/';
    $email_reg = '/.+@.+\.[a-zA-Z]+/';
    $pass_reg = '/.+/';

    $min_len = array("firstname" => 1, "lastname" => 1, "email" => 5, "password" => 1);
    $max_len = array("firstname" => 255, "lastname" => 255, "email" => 254, "password" => 255);

    function is_valid_length($str, $minlen, $maxlen){
        $strlen = strlen($str);
        return $strlen >=$minlen && $strlen <= $maxlen;
    }
?>