<?php
    require_once('common/db_ops.php');
    require_once('common/utilities.php');
    require_once('../../db_connections/connections.php');
    if (!isset($link)){
        $link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
    }
    
    $query = "DROP TABLE users";
    my_oo_query($link, $query);

    $query = "CREATE TABLE users (
        id MEDIUMINT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(254) UNIQUE NOT NULL,
        firstname VARCHAR(256) NOT NULL, 
        lastname VARCHAR(256) NOT NULL,
        username VARCHAR(256) UNIQUE NOT NULL,
        address VARCHAR(256),
        phone VARCHAR(15) 
        ); ";

    $query = "DROP TABLE products";
    my_oo_query($link, $query);

    $query = "CREATE TABLE products (
        id MEDIUMINT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(256) NOT NULL,
        author VARCHAR(256) REFERENCES users(username) ON UPDATE CASCADE ON DELETE CASCADE,
        filename VARCHAR(255) NOT NULL,
        price DECIMAL(12,2) NOT NULL, -- https://youtu.be/ehcp_lI5CAc?t=55
        ); ";
    my_oo_query($link, $query);

?>