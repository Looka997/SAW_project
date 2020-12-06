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
            <option value="tshirt">T-shirt</option>
            <option value="lsleeves">Long sleeves</option>
            <option value="sweater">Sweater</option>
        </select>
        <label for="upload">Upload a custom image (.jpeg, .jpg, .png):</label>
        <input type="file" name="upload" id="upload">
        <input type="submit" name="submit_design" value="submit">
    </form>
    
</body>
</html>