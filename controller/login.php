<?php
echo "открыт контроллер логин\n";
// подключаем model авторизации
include_once "model/auth.php";

// перееадресовываем post в модель, в ответ получаем ошибки
$errors = authLogin($_POST);
echo "200";
// подключаем страницу с автооризацией (внешний вид)
include_once "view/login.php";