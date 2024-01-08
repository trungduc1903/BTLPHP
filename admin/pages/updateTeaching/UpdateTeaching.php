<?php
include('../../../config/connect.php');
if(isset($_POST["updateTeaching"])){
    $teacherId = $_POST["teacherId"];
    $semester = $_POST["semester"];
    $subjectId = $_POST["subjectId"];
    $year = $_POST["year"];
    $classId = $_POST["classId"];
    
    if($teacherId == "NULL"){
        $updateTeachingStmt = "CALL proc_teacherClass_update(NULL,'$classId',$semester,$year,'$subjectId')";
    }else
        $updateTeachingStmt = "CALL proc_teacherClass_update('$teacherId','$classId',$semester,$year,'$subjectId')";
    $result = mysqli_query($conn,$updateTeachingStmt);
   
    header("Location: ../../index.php?page=class_teaching&id=".$classId);
    
}