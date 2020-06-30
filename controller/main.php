<?php

// подключаем model
include_once "model/saveLoad.php";

// перееадресовываем post в model, и возвращаем ошибки
$viewTable = loadTable($_POST);

// подключаем страницу с автооризацией (внешний вид)
include_once "view/main.php";
