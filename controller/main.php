<?php

// чек авторизации
if (!isset($_SESSION['logged_user'])){
    header("Location: /");
    exit();
}

// подключаем model
include_once "model/saveLoad.php";

// узнаем страницу к которой обращаемся
$checkURL = substr($url, 11, -4);


// обращаемся к model
$viewTable = $checkURL();

// подключаем внешний вид
include_once "view/main.php";
