<?php 
    function my_prepared_stmt($link, $query, $types, ...$parameters){
        $stmt = mysqli_stmt_init($link);
        if (!mysqli_stmt_prepare($stmt,$query)){
            echo "failed mysqli_stmt_prepare";
            exit;
        }
        if (!mysqli_stmt_bind_param($stmt, $types, ...$parameters)){
            echo "failed bind_params";
            exit;
        }
        if (!mysqli_stmt_execute($stmt)){
            echo "failed mysqli_stmt_execute";
            exit;
        }
        //stmt is still to be closed
        return $stmt;       
    }

    function my_oo_prepared_stmt($con, $query, $types, ...$parameters){
        if ($stmt = $con->prepare($query)){
            $stmt->bind_param($types,...$parameters);
            $stmt->execute();
        }else{
            echo $con->error;
            die;
        }
        //stmt is still to be closed
        return $stmt;
    }

    function myquery($link, $query){
        $res = mysqli_query($link, $query);
        if ($res == FALSE){
            echo mysqli_error($link);
            exit;
        }
        return $res;
    }

    function my_oo_query($con, $query){
        $res = $con->query($query);
        if ($res == FALSE){
            echo($con->error);
            exit;
        }
        return $res;
    }
    
?>
