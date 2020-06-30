<?php
echo "открыт модуль авторизации\n";

function authLogin($data1){
    $configs = require "../config.php";
    $errors = array();

    if (isset($data['signin'])){
        if(trim($data['login']) == ''){
            $errors[] = "Username can't be empty";
        }
        if($data['password'] == ''){
            $errors[] = "Password can't be empty";
        }
        if (empty($errors)) {
            $mysql = new mysqli($configs['localhost'], $configs['username'], $configs['password'], $configs['dbname']);
            $cursor = $mysql->query("SELECT * FROM `user` WHERE `login` = '".$data['login']."';");
            $result = $cursor->fetch_assoc();
            if ($result){
                if (password_verify($data['password'], $result['password'])){
                    $_SESSION['logged_user'] = $result;
                    $mysql->close();
                    header("Location: /main");
                    exit();
                }
            }
            $errors[] = "Email or Password is not correct!";
            $mysql->close();
        }
    }

    return $errors;
}