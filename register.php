<?php
require "config.php";
$configs = include('config.php');
$regok = false;
$data = $_POST;
$errors = array();
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
	if (empty($errors)) {
		$mysql = new mysqli($configs['localhost'], $configs['username'], $configs['password'], $configs['dbname']);
		$cursor = $mysql->query("CHECK TABLE user;");
		$result = $cursor->fetch_assoc();
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
		$cursor = $mysql->query("SELECT * FROM `user` WHERE `login` = '".$data['login']."' OR `email` = '".$data['email']."';");
		$result = $cursor->fetch_assoc();
		if (count($result) != 0){
			$errors[] = "That username or email already exists";
		}else{
			$mysql->query("INSERT INTO `user` (`login`, `email`, `password`) VALUES ('".$data['login']."', '".$data['email']."', '".password_hash($data['password'], PASSWORD_DEFAULT)."');");
			$mysql->close();
			$regok = true;
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/login.css">
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
	<title>Авторизация</title>
</head>
<body>
	<form class="container" action="register.php" method="post">
  		<h1>Registration</h1>
  		<?php 
  		if(!empty($errors)){
  			echo '<div class="errorlogin">'.array_shift($errors).'</div>';
  		}
  		if($regok){
  			echo '<div class="errorlogin" style="color: #53B82D">Registration completed successfully</div>';
  		}
  		?>
  		<input type="text" name="login" placeholder="Login" spellcheck="false" value="<?php if(!$regok){echo @$data['login'];} ?>">
  		<input type="text" name="email" placeholder="E-mail" spellcheck="false" value="<?php if(!$regok){echo @$data['email'];} ?>">
  		<input type="password" name="password" placeholder="Password">
  		<input type="password" name="password2" placeholder="Repeat password">
  		<input type="submit" name="create" value="Create">
  		<a href="/" style="text-align: center; width: 260px;">Sign in</a>
	</form>
</body>
</html>
