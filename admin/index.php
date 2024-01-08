<?php 
    session_start();
    if(isset($_SESSION["user"]["userId"]) == null){
        header("Location: login.php");  
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>    
    <link rel="stylesheet" href="../asset/font-awesome-pro-5/css/all.min.css">
    <link rel="stylesheet" href="../asset/font-awesome-pro-5//webfonts">
    <link rel="stylesheet" href="./index.css">
    <link rel="stylesheet" href="./App.css">
    <link rel="stylesheet" href="./components/navbar/navbar.css">
</head>
<body>   
    <?php include_once('./App.php') ?>
    
</body>
    
</html>
