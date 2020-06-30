<?php
// подключаем model авторизации
include_once "model/auth.php";

// перееадресовываем post в model, в ответ получаем ошибки
$data = $_POST;
if (isset($data['signin']))
    $errors = authLogin($data);

// подключаем страницу с автооризацией (внешний вид)
include_once "view/login.php";