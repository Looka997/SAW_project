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
    
    $query = "DROP TABLE IF EXISTS orders";
    my_oo_query($link, $query);

    $query = "CREATE TABLE models (
        id MEDIUMINT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL UNIQUE,
        filename VARCHAR(255) NOT NULL UNIQUE,
        price DECIMAL (12,2) NOT NULL, -- inherent cost of materials; a design of x model cannot be priced under price
        image_x_ratio DECIMAL(5, 4) NOT NULL,
        image_y_ratio DECIMAL(5, 4) NOT NULL,
        image_w_ratio DECIMAL(5, 4) NOT NULL,
        image_h_ratio DECIMAL(5, 4) NOT NULL
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

    $query = "DROP TABLE IF EXISTS reviews";
    my_oo_query($link, $query);
    $query = "CREATE TABLE reviews(
        id MEDIUMINT AUTO_INCREMENT PRIMARY KEY,
        content VARCHAR(500),
        score DECIMAL(3,1) NOT NULL CHECK (score BETWEEN 1 AND 5),
        product MEDIUMINT REFERENCES products(id) ON UPDATE CASCADE ON DELETE CASCADE,
        author MEDIUMINT REFERENCES user(id) ON UPDATE CASCADE ON DELETE CASCADE,
        CONSTRAINT reviews UNIQUE(author,product)
    )";
    my_oo_query($link, $query);
    
    $query = "CREATE TABLE orders(
        id MEDIUMINT AUTO_INCREMENT PRIMARY KEY,
        user_id MEDIUMINT NOT NULL REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
        prod_id MEDIUMINT NOT NULL REFERENCES products(id) ON UPDATE CASCADE ON DELETE CASCADE
    )";
    my_oo_query($link, $query);

    $query = "INSERT INTO users (email, password, firstname, lastname, username, address, phone, admin) VALUES 
    ('luca@marinelli.it','" . password_hash('prova1', PASSWORD_DEFAULT) . "','Luca', 'Marinelli', 'Looka', 'sotto casa mia 123, Genova', '123 1231 23', TRUE),
    ('fede@crippa.it','" . password_hash('prova2', PASSWORD_DEFAULT) . "','Federico', 'Crippa', 'Fedez', 'sotto casa sua 456, La Spezia', '456 4567 45', TRUE),
    ('ale@morciano.it','" . password_hash('prova3', PASSWORD_DEFAULT) . "','Alessio', 'Morciano', 'AleMagno', 'mai a casa mia 789, Savona', '789 7891 07', TRUE),
    ('giorno@giovanna.it','" . password_hash('prova4', PASSWORD_DEFAULT) . "','Giorno', 'Giovanna', 'Requiem', 'Mamma mia, Napoli', '333 3333 33', FALSE),
    ('senza@address.it','" . password_hash('prova5', PASSWORD_DEFAULT) . "','Senza', 'Address', 'Hobo', NULL, '399 3999 99', FALSE),
    ('phone@less.it','" . password_hash('prova6', PASSWORD_DEFAULT) . "','Phone', 'Less', 'OldFashioned123', 'Vivoquantomeno 25, Chiavari', NULL, FALSE),
    ('vero@antico.it','" . password_hash('prova7', PASSWORD_DEFAULT) . "','Vero', 'Antico', 'Amish', NULL, NULL, FALSE),
    ('gian@vandome','" . password_hash('prova8', PASSWORD_DEFAULT) . "','Monet', 'Monet', NULL, 'Stradet XIX, Parigi', NULL, FALSE),
    ('il@nono.it','" . password_hash('prova9', PASSWORD_DEFAULT) . "','Eren', 'Yeger', 'EREN', 'Casa 9, Novi', '666666666666', FALSE),
    ('ponte@decimo.it','" . password_hash('prova10', PASSWORD_DEFAULT) . "','Fiume', 'D\'Annunzio', 'CeLoRiprendiamo', 'Via dei Mille 1000, Fiume, Croazia', '99909990', FALSE),
    ('re@undicesimo.it','" . password_hash('prova11', PASSWORD_DEFAULT) . "','Vero', 'Re', 'KingOfTheMountain', 'Via XX settembre 20,Pizzo Calabro', '1234', FALSE),
    ('prossimoin@carica.it','" . password_hash('prova12', PASSWORD_DEFAULT) . "','Vero', 'Erede', 'Chissaseciarrivo', 'Via XX settembre 20, Pizzo Calabro', NULL, FALSE),
    ('jotaro@joestar.jp','" . password_hash('prova13', PASSWORD_DEFAULT) . "','Jotaro', 'Joestar', 'Jotaro', 'Via Yare Yare 1234,Tokyo,Giappone', NULL, FALSE),
    ('jolyne@joestar.us','" . password_hash('prova14', PASSWORD_DEFAULT) . "','Jolyne', 'Joestar', 'HateMyFather2006', 'Dolphin Prison, Florida', '2006 99999', FALSE),
    ('jonathan@joestar.co.uk','" . password_hash('prova15', PASSWORD_DEFAULT) . "','Jonathan', 'Joestar', 'OGZawarudo', 'Magione Joestar, Inghilterra', NULL, FALSE)
    ";
    
    my_oo_query($link, $query); 

    $query = "INSERT INTO products (name, model, author, filename, price) VALUES 
    ('Paper Mario!', 'T-shirt', 1, 'paper-mario.jpg', 9.99),
    ('Vita da Trullo', 'T-shirt', 2,'trullo.jpg', 11.99),
    ('HTML is for bois', 'T-shirt', 2,'lessgreaterthen.jpg', 20.91)";
    my_oo_query($link, $query);

    $query = "INSERT INTO models (name, filename, price, image_x_ratio, image_y_ratio, image_w_ratio, image_h_ratio) VALUES
    ('Tanktop', 'tanktop.svg', 7.00, 0.2455, 0.4, 0.5111, 0.2083),
    ('T-shirt', 'tshirt.svg', 10.00, 0.2785, 0.36, 0.4555, 0.2583),
    ('Hoody', 'hoody.svg', 20.00, 0.32, 0.45, 0.375, 0.1583)
    ";
    my_oo_query($link, $query);

    $query = "INSERT INTO reviews (content, score, product, author) VALUES
    (NULL, 4.5, 1, 4),
    (NULL, 5, 3, 6),
    (NULL, 3.5, 2, 10),
    (NULL, 2, 2, 11),
    (NULL, 1, 1, 12),
    (NULL, 2.5, 3, 13),
    ('Incredibile, vorrei facesse più design', 5, 1, 13),
    ('La sua unica pecca', 2.5, 1, 2),
    ('Consegna impeccabile come al solito!', 5, 1, 3),
    ('Questo autore mi sorprende sempre', 4.5, 1, 6),
    ('Unica macchia nera nel suo repertoire', 1, 1, 1),
    ('Peccato non fosse disponibile in più colori', 4, 1, 8),
    ('Il mio nipotino ha apprezzato tantissimo', 5, 1, 5),
    ('Sempre voluta una maglia così', 5, 1, 9),
    ('r/programmerhumor apprezzerebbe', 4, 3, 8),
    ('Ne ho prese due!', 5, 3, 1),
    ('Presa questa.... per me e per entrambi i figli...!!', 5, 3, 2),
    ('Purtroppo da me i corrieri non arrivano, me l\'ha consegnata un amico', 3, 3, 11),
    ('Bellissimi i colori di questa', 4, 3, 3),
    ('Sempre piaciuti i trulli. Pugliese con la GL maiuscola.', 5, 2, 4),
    ('Almeno quattro!', 4, 3, 9),
    ('Non è piaciuta all\'amico per cui l\'ho presa', 2.5, 3, 4),
    ('Sono l\'amico di quello di prima, in realta mi è piaciuta, ma non capisce perché', 5, 3, 10),
    ('che design!!', 2.5, 2, 1),
    ('Ho sbagliato a mettere il voto, ma non so come annullare..fa schifo...', 4.5, 2, 6),
    ('Lorem ipsum', 1.5, 2, 3),
    ('Questa è l\'ultima finta review che scrivo', 1.5, 2, 8);
    ";
    my_oo_query($link, $query);

    echo "AAAAAAAAAAAAAAAAAAAA";
    header("Location: logout.php");
    exit;
?>
