<?php

    include('../../../config/connect.php');
    $id = '';
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }
    echo $id;
    $delUserStmt = "CALL proc_user_del('$id')";
    mysqli_query($conn, $delUserStmt);
    header("Location: ../../index.php?page=user");
    echo $conn->error;
    
?>