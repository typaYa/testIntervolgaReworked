<?php
use src\RepositoriesReviews;
require __DIR__ . '/vendor/autoload.php';
require 'config.php';
if (isset($_POST['submit'])){
    $RepositoriesReviews = new RepositoriesReviews("$path");
    $text = $_POST['text'];
    $RepositoriesReviews->addReview($text);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<style>
    .text{
        color: #656565;
        margin-top: 30px;
        flex-direction: column;
        min-width: 500px;
        outline: none;
        border: none;
        border-bottom: 1px solid black;
    }
    .submit{
        background: none;
        border: 1px solid #a2a2a2;
        margin-top: 20px;
        transition: 0.3s;
        min-width: 500px;
    }
    .submit:hover{
        background-color: #d2d1d1;
    }
    .form{
        background-color: #ffffff;
        margin:auto;

        max-width: 500px;

    }
</style>
<form class="form" action="" method="post" >
    <p style=" margin-top: 120px;color: #656565">Ваш отзыв</p>
    <input class="text" type="text" name="text" placeholder="Напишите отзыв">
    <input class="submit" type="submit" name="submit" >
</form>



</body>
</html>