<?php
    require_once('../public_html/common/db_ops.php');
    require_once('../public_html/common/utilities.php');
    require_once('../db_connections/connections.php');
    if (!isset($link)){
        $link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
    }
    
    $query = "DROP TABLE IF EXISTS users";
    my_oo_query($link, $query);

    $query = "CREATE TABLE users (
        id MEDIUMINT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(254) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        firstname VARCHAR(256) NOT NULL, 
        lastname VARCHAR(256) NOT NULL,
        username VARCHAR(256) UNIQUE,
        address VARCHAR(256),
        phone VARCHAR(15),
        admin BOOLEAN DEFAULT FALSE
        ) ";
    my_oo_query($link, $query);

    $query = "DROP TABLE IF EXISTS products";
    my_oo_query($link, $query);

    $query = "DROP TABLE IF EXISTS models";
    my_oo_query($link, $query);
    
    $query = "CREATE TABLE models (
        id MEDIUMINT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL UNIQUE,
        filename VARCHAR(255) NOT NULL UNIQUE,
        price DECIMAL (12,2) NOT NULL -- inherent cost of materials; a design of x model cannot be priced under price
        ) ";
    my_oo_query($link, $query);

    $query = "CREATE TABLE products (
        id MEDIUMINT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(256) NOT NULL,
        model VARCHAR(30) REFERENCES models(name) ON UPDATE RESTRICT ON DELETE RESTRICT,
        author MEDIUMINT REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
        filename VARCHAR(255) NOT NULL,
        price DECIMAL(12,2) NOT NULL -- https://youtu.be/ehcp_lI5CAc?t=55
        ) ";
    my_oo_query($link, $query);
    

    $query = "INSERT INTO users (email, password, firstname, lastname, username, address, phone, admin) VALUES 
    ('luca@marinelli.it','" . password_hash('prova1', PASSWORD_DEFAULT) . "','Luca', 'Marinelli', 'Looka', 'sotto casa mia 123, Genova', '123 1231 23', TRUE),
    ('fede@crippa.it','" . password_hash('prova2', PASSWORD_DEFAULT) . "','Federico', 'Crippa', 'Fedez', 'sotto casa sua 456, La Spezia', '456 4567 45', TRUE),
    ('ale@morciano.it','" . password_hash('prova3', PASSWORD_DEFAULT) . "','Alessio', 'Morciano', 'AleMagno', 'mai a casa mia 789, Savona', '789 7891 07', TRUE),
    ('giorno@giovanna.it','" . password_hash('prova4', PASSWORD_DEFAULT) . "','Giorno', 'Giovanna', 'Requiem', 'Mamma mia, Napoli', '333 3333 33', FALSE),
    ('senza@address.it','" . password_hash('prova5', PASSWORD_DEFAULT) . "','Senza', 'Address', 'Hobo', NULL, '399 3999 99', FALSE),
    ('phone@less.it','" . password_hash('prova6', PASSWORD_DEFAULT) . "','Phone', 'Less', 'OldFashioned123', 'Vivoquantomeno 25, Chiavari', NULL, FALSE),
    ('vero@antico.it','" . password_hash('prova7', PASSWORD_DEFAULT) . "','Vero', 'Antico', 'Amish', NULL, NULL, FALSE)";
    my_oo_query($link, $query); 

    $query = "INSERT INTO products (name, model, author, filename, price) VALUES 
    ('Paper Mario!', 'T-shirt', 1, 'paper-mario.jpg', 14.99),
    ('Vita da Trullo', 'T-shirt', 2,'trullo.jpg', 11.99),
    ('HTML is for bois', 'T-shirt', 2,'lessgreaterthen.jpg', 19.91)";
    my_oo_query($link, $query);

    $query = "INSERT INTO models (name, filename, price) VALUES
    ('Tanktop', 'tanktop.svg', 7.00),
    ('T-shirt', 'tshirt.svg', 10.00),
    ('Hoody', 'hoody.svg', 20.00 )
    ";
    my_oo_query($link, $query);

    header("Location: ../public_html/common/logout.php");
    exit;
?>