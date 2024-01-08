<?php

include('../../../config/connect.php');

if (isset($_POST["cancel"])) {
    $classId = $_POST['classId'];
    $subjectId = $_POST['subjectId'];
    header("Location: ../../index.php?page=score_student&studentId=$studentId&classId=$classId");
}

if (isset($_POST["update"]) || isset($_POST["cancel"])) {
    $year = $_POST['year'];
    $semester = $_POST['semester'];
    $studentId = $_POST['studentId'];
    $classId = $_POST['classId'];
    $subjectId = $_POST['subjectId'];
    if (isset($_POST["cancel"])) {
        header("Location: ../../index.php?page=score_student&studentId=$studentId&classId=$classId");
    } else {
        $oralTest = $_POST["oralTest"];
        $fifTest1 = $_POST["fifTest1"];
        $fifTest2 = $_POST["fifTest2"];
        $periodTest1 = $_POST["periodTest1"];
        $periodTest2 = $_POST["periodTest2"];
        $finalTest = $_POST["finalTest"];

        if ($oralTest == "") $oralTest =  "NULL";
        if ($fifTest1 == "") $fifTest1 =  "NULL";
        if ($fifTest2 == "") $fifTest2 =  "NULL";
        if ($periodTest1 == "") $periodTest1 =  "NULL";
        if ($periodTest2 == "") $periodTest2 =  "NULL";
        if ($finalTest == "") $finalTest =  "NULL";

        $updateScoreStmt = "CALL proc_score_update('$studentId','$classId','$subjectId',$year, $semester, $oralTest, $fifTest1, $fifTest2, $periodTest1, $periodTest2,$finalTest)";
        $result = mysqli_query($conn, $updateScoreStmt);
        if ($result) {
            echo "success";
            header("Location: ../../index.php?page=score_student&studentId=$studentId&classId=$classId");
        } else {
            echo $conn->error;
        }
    }
}
