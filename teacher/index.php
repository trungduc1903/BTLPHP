<?php
session_start();
    
if(!isset($_SESSION["teacher"]["teacherId"])){
    header("Location: ./login.php");
}

include('../config/connect.php');
$date = getdate();

if(!isset($_SESSION["schoolYear"])){
   $_SESSION["schoolYear"] = getdate()["year"];   
}

if(!isset($_SESSION["semester"])){
    $_SESSION["semester"] = 1;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="App.css">
    <title>Document</title>
    <link rel="stylesheet" href="../asset/font-awesome-pro-5/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    
</head>

<body>
    <?php
        include_once('App.php');
    ?>

</body>

</html>