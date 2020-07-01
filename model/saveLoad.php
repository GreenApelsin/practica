<?php
function dbConnect(){
    $configs = include_once 'config.php';
    return new mysqli($configs['localhost'], $configs['username'], $configs['password'], $configs['dbname']);
}
function file_force_download($file){
    if (file_exists($file)) {
        // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
        // если этого не сделать файл будет читаться в память полностью!
        if (ob_get_level()) {
            ob_end_clean();
        }
        // заставляем браузер показать окно сохранения файла
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        // читаем файл и отправляем его пользователю
        readfile($file);
    }
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
    if (isset($_SESSION['GET']))
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

