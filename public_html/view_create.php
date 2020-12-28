<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Crea il tuo design </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="favicon.png" type="image/png">
</head>
<body>
    <!-- vorrei fare in modo che un user non loggato possa creare il design, e nel caso la conferma
    lo rimandi al login o eventualmente registrazione. 
    Fatta questa, dovrebbe essere reindirizzato su questa pagina -->
    
    <?php 
        session_start();
        require_once("../db_connections/connections.php");
        $link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
        require_once("common/navbar.php");
        require("common/get_keywords.php");
    ?>

    <?php
        if (isset($_GET[ERROR])) {
            require_once("common/error_codes.php");


            $format = "<div class=\"alert alert-danger text-center alert-dismissible fade show\" role=\"alert\">
                %s
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\">
                </button>
            </div>";
            foreach ($_GET[ERROR] as $errno) {
                $error = "";
                switch ($errno) {
                    case DB_DUP_ERR:
                        $error = sprintf($format, "Name already in use.");
                        break;
                    case DB_GENERIC_ERR:
                    case GENERIC_ERR:
                        $error = sprintf($format, "An error has occured.");
                        break;
                    case WRONG_FORMAT_ERR:
                        $error = sprintf($format, "Something was spelled wrong or the format doesn't respect what we expect.");
                        break;
                    case NOT_SET_ERR:
                        $error = sprintf($format, "Something wasn't set correctly.");
                        break;
                    case WRONG_MIME_ERR:
                        $error = sprintf($format, "Wrong image type.");
                        break;
                    default:
                        $error = sprintf($format, "An unexpected error has occured.");
                }
    
                echo $error;
            }
        }
    ?>
    <form action="create.php" method="POST" enctype="multipart/form-data">
        <?php 
            $precompiled = false;
            if (isset($_SESSION["create_POST"])){
                $precompiled = true;
                $fields = $_SESSION["create_POST"];
            }
        ?>
        <div class="input-create">
            <h1> Crea il tuo design! </h1>
            <h2> Inizia a creare il tuo capo, selezionando fra tre bellssimi modelli (canottiera, t-shirt e felpa), carica la tua immagine preferita, dagli un nome e un prezzo ed il gioco è fatto!</h2>
            <br><br> 
            <label for="design_name">Inserisci un nome per il tuo design:</label>
            <input type="text" name="design_name" id="design_name" value="<?php echo $precompiled ? $fields["design_name"] : ""; ?>">
            <br><br> 
            <label for="model">Seleziona un modello:????</label>
            <select name="model" id="model">
                <?php 
                    require_once('common/db_ops.php');
                    require_once('common/utilities.php');
                    $query = 'SELECT name, filename, price FROM models';
                    $result = my_oo_query($link, $query);
                    $models = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    $_SESSION["model_names"] = array();
                    foreach($models as $model):    
                        $model_name = $model['name']; 
                        // così non dovremmo rifare la stessa query in handle_create
                        array_push($_SESSION["model_names"], $model_name); 
                        ?>
                        <option value="<?php echo $model_name?>" <?php echo $precompiled && ($model_name === $fields['model']) ? "selected" : ""; ?> ><?php echo $model_name  ?></option>       
                <?php endforeach ?>
            </select>
            <br><br> 
            <label for="upload">Carica la tua immagine (.jpeg, .jpg, .png):</label>
            <input type="file" name="upload" id="upload" accept="image/png, image/jpeg">
            <br><br>       
            <label for="design_price">Insersci il prezzo del tuo design ???(a minimum will be set depending on chosen model)???: </label>
            <!-- TODO: set a minimum price depending on chosen model_name; -->
            <input type="number" name="design_price" id="design_price" value="<?php echo $precompiled ? $fields["design_price"] : ""; ?>">

            <div class="d-flex justify-content-center mt-5">
             <button class="btn btn-primary" type="submit" name="design_submit" value="submit">Continua</button>
            </div>
        </div>
    </form>

        <canvas id="graphics_tablet"></canvas>
        <script src="js/graphics_tablet.js"></script>

    <?php
        require("common/footer.php");
    ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>  
</body>
</html>