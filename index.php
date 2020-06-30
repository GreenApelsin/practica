<?php
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);
ini_set('display_errors', '1');

session_start();

$url = $_SERVER['REQUEST_URI'];

if ($url == '/')
    $url = "controller/login.php";
else
    $url = "controller/".$url.".php";

// ищем страницу по url в папке 'view'
if (file_exists($url)) {
    include_once $url;
}else{
    // если не нашли, то проверяем авторизацию
    if (isset($_SESSION['logged_user']))
        header("Location: /main");
    else
        header("Location: /");


}
