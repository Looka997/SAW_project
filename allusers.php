

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All users</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        session_start();
        require_once("../../db_connections/connections.php");
        $link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
        require("common/navbar.php");
        require_once("common/db_ops.php")
    ?>
    <table>
        <tr>
            <th>email</th>
            <th>firstname</th>
            <th>lastname</th>
        </tr>
        <?php 
            $query = "SELECT email, firstname, lastname FROM users";
            $orderby_reg = '/email|firstname|lastname/';
            if  (isset($_GET["ord"]) && preg_match($orderby_reg,$_GET["ord"])!=0){
                $query = $query . " ORDER BY " . mysqli_escape_string($link,$_GET["ord"]);
            }
            $res = myquery($link, $query);
            while ($row = mysqli_fetch_assoc($res)){
                echo "<tr>
                    <td> $row[email] </td>
                    <td> $row[firstname] </td>
                    <td> $row[lastname] </td>
                </tr>";
            }
        ?>
    </table>
</body>
</html>