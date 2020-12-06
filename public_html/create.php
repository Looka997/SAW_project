<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Create your own design </title>
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
    ?>
    <form action="handle_create.php" method="POST">
        <label for="design_name">Insert a name for your design:</label>
        <input type="text" name="design_name" id="design_name">
        <label for="model">Select a model:</label>
        <select name="model" id="model">
            <?php 
                require_once('common/db_ops.php');
                require_once('common/utilities.php');
                $query = 'SELECT name, filename, price FROM models';
                $result = my_oo_query($link, $query);
                $models = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $model_to_price = array();
                foreach($models as $model):         
                    $model_name = htmlspecialchars($model['name']); ?>
                    <option value="<?php echo $model_name?>"><?php echo $model_name  ?></option>       
            <?php endforeach ?>
        </select>
        <label for="upload">Upload a custom image (.jpeg, .jpg, .png):</label>
        <input type="file" name="upload" id="upload">
        <label for="design_price">Set a price for your design (a minimum will be set depending on chosen model): </label>
        <!-- TODO: set a minimum price depending on chosen model_name; -->
        <input type="number" name="design_price" id="design_price" value="">
        <input type="submit" name="submit_design" value="submit">
    </form>
    
</body>
</html>