<?php

// подключаем model авторизации
include_once "model/auth.php";

// перееадресовываем post в model, и возвращаем ошибки
$errors = authLogin($_POST);

// подключаем страницу с автооризацией (внешний вид)
include_once "view/login.php";
