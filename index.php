<?php
session_start();
require 'controller/config.php';
$url = "view/".$_SERVER['REQUEST_URI'].".php";

if (file_exists($url)){
    include_once $url;
}
