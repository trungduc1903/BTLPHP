<?php

$id = "";
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $teacherDelStmt = "CALL proc_teacher_del('$id')";
    $result = mysqli_query($conn, $teacherDelStmt);
    echo $conn->error;
    if ($result) {
        header("Location: ./index.php?page=teacher");
    }
}
