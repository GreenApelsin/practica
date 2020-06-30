<?php
// подключаем model авторизации/регистрации
include_once "model/auth.php";

// перееадресовываем post в model, и возвращаем ошибки
$errors = authReg($_POST);

// подключаем страницу с регистрацией (внешний вид)
include_once "view/register.php";
