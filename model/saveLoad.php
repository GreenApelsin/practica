<?php
function loadTable(){
    $configs = include 'config.php';

    // шапка
    $str = "<h1>Main page</h1><table><tr class='trtit'><th>Owner</th><th>File name</th></tr>";

    $mysql = new mysqli($configs['localhost'], $configs['username'], $configs['password'], $configs['dbname']);
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

function file_force_download($file) {
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