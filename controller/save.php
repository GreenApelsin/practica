<?php

// подключаем model
include_once "model/saveLoad.php";

if (isset($_SESSION['GET']['f'])) {
    file_force_download("support/file/".$_SESSION['GET']['f']);
    unset($_SESSION['GET']);
}else{
    unset($_SESSION['GET']);
}


