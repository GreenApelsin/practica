<?php
session_start();
require 'config.php';
$url = "view/".$_SERVER['REQUEST_URI'].".php";

// ищем страницу по url
if (file_exists($url))
    include_once $url;
else{
    //если не нашли, то проверяем авторизацию
    if (isset($_SESSION['logged_user']))
        include_once "view/main.php";
    else
        include_once "view/login.php";

}
