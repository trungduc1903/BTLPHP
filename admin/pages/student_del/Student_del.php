<?php

$classId = "";
if(isset($_GET["classId"])){
    $classId = $_GET["classId"];
}
if (isset($_GET["id"])) {
    $id = $_GET['id'];

    $studentDelStmt = "CALL proc_student_del('$id')";
    $deleteResult = mysqli_query($conn, $studentDelStmt);
    if ($deleteResult) {
        header("Location: ./index.php?page=class_students&id=$classId");
    }
    echo $conn->error;
}
