<?php

function authLogin($data){
    $configs = require "config.php";
    $errors = array();
    // проверяем откуда запрос
    if (isset($data['signin'])){

        // проверяем поля на пустоту
        if(trim($data['login']) == ''){
            $errors[] = "Username can't be empty";
        }
        if($data['password'] == ''){
            $errors[] = "Password can't be empty";
        }

        // проверяем наличие ошибок
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
            $errors[] = "Login or Password is not correct!";
            $mysql->close();
        }
    }

    return $errors;
}

function authReg($data){
    $configs = include 'config.php';
    $errors = array();

    // проверки полей
    if (isset($data['create'])){
        if(trim($data['login']) == ''){
            $errors[] = "Username can't be empty";
        }
        if(trim($data['email']) == ''){
            $errors[] = "Email can't be empty";
        }
        if(!strpos($data['email'], '@')){
            $errors[] = 'Email format is incorrect';
        }
        if($data['password'] == ''){
            $errors[] = "Password can't be empty";
        }
        if($data['password2'] == ''){
            $errors[] = "Confirm password";
        }
        if($data['password'] != $data['password2']){
            $errors[] = "Password mismatch";
        }

        // проверяем на наличие ошибок
        if (empty($errors)) {  // ошибок нет

            // подключаем бд
            $mysql = new mysqli($configs['localhost'], $configs['username'], $configs['password'], $configs['dbname']);

            // проверяем таблицу на сущ.
            $cursor = $mysql->query("CHECK TABLE user;");
            $result = $cursor->fetch_assoc();

            // если таблицы нет, создаем
            if ($result['Msg_type'] == 'Error'){
                $mysql->query("CREATE TABLE `user` (
	  						`id` int(11) NOT NULL,
	  						`login` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
	  						`email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  						`password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
							) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
                $mysql->query("ALTER TABLE `user` ADD PRIMARY KEY (`id`);");
                $mysql->query("ALTER TABLE `user` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            // чекаем на повтор логин и почту
            $cursor = $mysql->query("SELECT * FROM `user` WHERE `login` = '".$data['login']."' OR `email` = '".$data['email']."';");
            $result = $cursor->fetch_assoc();

            if (count($result) != 0){
                $errors[] = "That username or email already exists";
                $mysql->close();
            }else{  // если пользователь новый
                // добавляем строку
                $mysql->query("INSERT INTO `user` (`login`, `email`, `password`) VALUES ('".$data['login']."', '".$data['email']."', '".password_hash($data['password'], PASSWORD_DEFAULT)."');");
                $mysql->close();

                // делаем метку, что регистрация пройдена
                $_SESSION['regok'] = true;

                header("Location: /register");
                exit();
            }
        }
    }
}
