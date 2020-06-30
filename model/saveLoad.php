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
        $str = $str . $result['login'].'</td><td><a href="/save.php?f='.$result['name'].'">'.$result['real-name'].'</a></td></tr>';
        $flagg = !$flagg;
    }
    $mysql->close();

    // закрываем шапку
    $str = $str . "</table>";

    return $str;
}

