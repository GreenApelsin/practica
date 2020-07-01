<?php

include_once "editFile.php";

function dbConnect(){
    $configs = include_once 'config.php';
    return new mysqli($configs['localhost'], $configs['username'], $configs['password'], $configs['dbname']);
}



// главная страница вывод всей таблицы
function main(){

    // шапка
    $str = "<h1>Main page</h1><table><tr class='trtit'><th>Owner</th><th>File name</th></tr>";

    $mysql = dbConnect();
    $cursor = $mysql->query("SELECT `login`, `real-name`, `name` FROM `infofiles`, `user` WHERE `infofiles`.`author-id` = `user`.`id` ORDER BY `infofiles`.`id` DESC;");
    $flagg = true;

    // узнаем сколько строк нам возвращено
    while( $result = $cursor->fetch_assoc() ) {
        if ($flagg){
            $str = $str . '<tr><td>';
        }else{
            $str = $str . '<tr class="tr2"><td>';
        }
        $str = $str . $result['login'].'</td><td><a href="/save?f='.$result['name'].'">'.$result['real-name'].'</a></td></tr>';
        $flagg = !$flagg;
    }
    $mysql->close();

    // закрываем шапку
    $str = $str . "</table>";

    return $str;
}

// вывод отправленных файлов
function my(){

    // проверка на удалени файлов
    if (isset($_SESSION['GET']['del']))
        delFile($_SESSION['GET']['del']);

    // шапка
    $str = "<h1>My files</h1>";
    // проверка на удаление
    if (isset($_SESSION['delok'])) {
        $str = $str . '<div class="errorSend" style="color: #53B82D">File deleted</div>';
        unset($_SESSION['delok']);
    }
    $str = $str . '<table><tr class="trtit"><th>Delete?</th><th>File name</th></tr>';

    // вывод строк
    $mysql = dbConnect();
    $cursor = $mysql->query("SELECT `login`, `real-name`, `name` FROM `infofiles`, `user` WHERE `infofiles`.`author-id` = `user`.`id` AND `author-id` = '" . $_SESSION['logged_user']['id'] . "' ORDER BY `infofiles`.`id` DESC;");
    $flagg = true;
    // узнаем сколько строк нам возвращено
    while ($result = $cursor->fetch_assoc()) {
        if ($flagg) {
            $str = $str . '<tr><td>';
        } else {
            $str = $str . '<tr class="tr2"><td>';
        }
        $str = $str . '<a href="?del=' . $result['name'] . '">Delete</a></td><td><a href="/save?f=' . $result['name'] . '">' . $result['real-name'] . '</a></td></tr>';
        $flagg = !$flagg;
    }
    $mysql->close();


    // закрываем шапку
    $str = $str . "</table>";

    return $str;
}

// полученные
function received(){
    // шапка
    $str = '<h1>Received file</h1><table><tr class="trtit"><th>From whom</th><th>File name</th></tr>';

    $mysql = dbConnect();
    $cursor = $mysql->query("SELECT `login`, `real-name`, `name` FROM `infofiles`, `user` WHERE `infofiles`.`author-id` = `user`.`id` AND `where-id` = '".$_SESSION['logged_user']['id']."' ORDER BY `infofiles`.`id` DESC;");
    $flagg = true;
    //узнаем сколько строк нам возвращено
    while( $result = $cursor->fetch_assoc() ) {
        if ($flagg){
            $str = $str . '<tr><td>';
        }else{
            $str = $str . '<tr class="tr2"><td>';
        }
        $str = $str . $result['login'].'</td><td><a href="/save?f='.$result['name'].'">'.$result['real-name'].'</a></td></tr>';
        $flagg = !$flagg;
    }
    $mysql->close();

    // закрываем шапку
    $str = $str . "</table>";

    return $str;
}

// отправка
function send(){
    $errors = saveFile();
    // шапка
    $str = "<h1>Send file</h1><form action=\"send\" method=\"post\" enctype=\"multipart/form-data\" id=\"post\">";

    // проверка ошибок
    if(!empty($errors)){
        $str = $str . '<div class="errorSend">'.array_shift($errors).'</div>';
    }
    if(isset($_SESSION['sendok'])){
        $str = $str . '<div class="errorSend" style="color: #53B82D">File send</div>';
        unset($_SESSION['sendok']);
    }

    // поле с именем файла
    $str = $str . '<input type="text" name="name" placeholder="File name" spellcheck="false" ';
    if(isset($_SESSION['namefil'])) {
        $str = $str . 'value="' . @$_SESSION['namefil'] . '"';
        unset($_SESSION['namefil']);
    }
    $str = $str . '>';

    //грузим список
    $mysql = dbConnect();
    $cursor = $mysql->query("SELECT `login` FROM `user` WHERE id != '".$_SESSION['logged_user']['id']."';");
    $str = $str . '<select name="select"><option selected="true" disabled="disabled">Selected user</option>';
    while( $result = $cursor->fetch_assoc() ) {
        $str = $str . '<option>'.$result['login'].'</option>';
    }
    $str = $str . '</select>';
    $mysql->close();

    // конец
    $str = $str . '<input type="submit" name="send" value="Send"><div class="filesend" id="filesend">
	  			<input type="file" title=" " name="upload" id="upload" onchange="getName(this.value);" />
	  			<div id="fileformlabel">Выбери или перетащи</div>
	  		</div>
		</form>';

    return $str;
}

