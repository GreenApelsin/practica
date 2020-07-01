<?php
//error_reporting(E_ALL);
//ini_set('display_startup_errors', 1);
//ini_set('display_errors', '1');

session_start();

$url = $_SERVER['REQUEST_URI'];

function wrGET($str){
    $_SESSION['GET'] = array();
    // получаем все что после '?'
    while (true){

        $pos = strpos($str, '=');
        $nameGET = substr($str,0, $pos);
        $str = substr($str, $pos +1 );

        // проверка на след. переменную
        $nextGET = strpos($str, '&');
        if ($nextGET) {
            $pos = strpos($str, '&');
            $_SESSION['GET'][$nameGET] = substr($str, 0, $pos);
            $str = substr($str, $pos + 1);
        }else {
            $_SESSION['GET'][$nameGET] = $str;
            break;
        }
    }
}

if ($url == '/')
    $url = "controller/login.php";
else{
    // ищем GET в url'e
    $pos = strpos($url,'?');
    // если нашли то записываем, и чистим $url
    if ($pos) {
        wrGET(substr($url, $pos + 1));
        $url = substr($url, 0, $pos);
    }

    $url = "controller".$url.".php";
}


// ищем страницу по url в папке 'controller' или из списка
if (file_exists($url))  {
    include_once $url;
}else
    if (($url == "controller/my.php") or ($url == "controller/send.php") or ($url == "controller/received.php")){
        include_once "controller/main.php";
    }else {
        // если не нашли, то проверяем авторизацию
        if (isset($_SESSION['logged_user']))
            header("Location: /main");
        else
            header("Location: /");
    }

