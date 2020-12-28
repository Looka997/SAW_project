<?php 
    $fstname_reg = '/^[^\s].+/';
    $lastname_reg = '/^[^\s].+/';
    $email_reg = '/^.+@.+\.[a-zA-Z]+$/';
    $pass_reg = '/.+/';
    $username_reg= '/^[^\s].+/';
    $address_reg = '/(^$|.+)/';
    $phone_reg = '/(^$|.+)/';
    $design_name_reg = '/^[^\s].+/';
    $design_price_reg = '/^[1-9][0-9]*([\.,][0-9][1-9]*)?$/';

    $min_len = array("firstname" => 1, "lastname" => 1, "email" => 5, "username" => 1, "address" => 1, "phone" => 1, "design_name" => 1, "design_price" => 1);
    $max_len = array("firstname" => 255, "lastname" => 255, "email" => 254, "username" => 256, "address" => 256, "phone" => 15, "design_name" => 256, "design_price" => 13);

    function is_valid_length($str, $minlen, $maxlen){
        $strlen = strlen($str);
        return $strlen >=$minlen && $strlen <= $maxlen;
    }
?>