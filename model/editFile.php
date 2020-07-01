<?php

// удалить
function delFile($name){
    $mysql = dbConnect();
    $mysql->query("DELETE FROM `infofiles` WHERE `name` = '".$name."';");
    unset($_SESSION['GET']['del']);
    $_SESSION['delok'] = true;
    header("Location: /my");
    exit();
}

// скачать
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

// загрузка
function saveFile(){
    $errors = array();
    $data = $_POST;

    if (isset($data['send'])) {
        if(trim($data['name']) == ''){
            $errors[] = "File name can't be empty";
        }else
            $_SESSION['namefil'] = $data['name'];
        if(trim($data['select']) == ''){
            $errors[] = "Selected user can't be empty";
        }

        //проверяем $_FILES на наличие и наличие загруженного файла
        if (isset($_FILES['upload']) && $_FILES['upload']['name'] != "") {
            if (empty($errors)) {
                //гененируем имя файла, что бы можно было загружать с одинаковыми именами
                $endname = substr($_FILES['upload']['name'],strpos($_FILES['upload']['name'], "."));
                $gennsme = time()."_".$_SESSION['logged_user']['id'].$endname;

                // загружаем файл
                move_uploaded_file($_FILES['upload']['tmp_name'], "support/file/".$gennsme);

                $mysql = dbConnect();

                //получаем id полуателя
                $cursor = $mysql->query("SELECT `id` FROM `user` WHERE `login` = '".$data['select']."'");
                $id = $cursor->fetch_assoc();

                //проверяем таблицу 'infofiles' на наличие
                $cursor = $mysql->query("CHECK TABLE infofiles;");
                $result = $cursor->fetch_assoc();
                if ($result['Msg_type'] == 'Error'){
                    $mysql->query("CREATE TABLE `infofiles` (
								`id` int(11) NOT NULL,
								`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
								`real-name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
								`author-id` int(11) NOT NULL,
								`where-id` int(11) NOT NULL
								) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
                    $mysql->query("ALTER TABLE `infofiles` ADD PRIMARY KEY (`id`);");
                    $mysql->query("ALTER TABLE `infofiles` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
                }
                //записываем строку в базу
                $mysql->query("INSERT INTO `infofiles` (`name`, `real-name`, `author-id`, `where-id`) VALUES ('".$gennsme."', '".$data['name']."', '".$_SESSION['logged_user']['id']."', '".$id['id']."');");
                $mysql->close();
                $_SESSION['sendok'] = true;
                unset($_SESSION['namefil']);
                header("Location: /send");
                exit();
            }
        }else{
            $errors[] = "File can't be empty";
        }


    }

    return $errors;

}