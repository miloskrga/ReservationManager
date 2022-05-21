<?php
session_start();
require_once "../BLL/DbHandler.php";
require_once "../funkcije.php";
$possition = "";

if(!login()){
    echo "Morate se ulogovati da bi ste videli ovu stranicu!<br>";
    echo '<a href="login.php">LogIn</a>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/homemain.css">
    <script src="../js/fontawesome.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <style>

    .aside-container{
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    
    .aside-container{
        flex-basis: 20%;
        max-width: 20%;
        width: 100%;
        background-color: black;
    }

    .aside-container .wrapper-aside .aside a{
        color: #fff;
    }

    </style>
</head>
<body>