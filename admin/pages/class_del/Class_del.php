<?php
ob_start();
$id = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $classDelStmt = "CALL proc_class_del('$id')";
    $result = mysqli_query($conn, $classDelStmt);
    if ($result) {
        header("Location: ./index.php?page=class");
    }else{
        header("Location: ./index.php?page=class&error=1");
    }
    echo $conn->error;
}
ob_end_flush();