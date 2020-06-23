<?php
require "config.php";
$configs = include('config.php');
$data = $_POST;
$errors = array();

if(isset($_SESSION['logged_user'])){
	header("Location: /main.php");
	exit();
}


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
				header("Location: /main.php");
				exit();
			}
		}
		$errors[] = "Email or Password is not correct!";
		$mysql->close();
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
	<form class="container" action="index.php" method="post">
  		<h1>Sign in to your account</h1>
  		<?php 
  		if(!empty($errors)){
  			echo '<div class="errorlogin">'.array_shift($errors).'</div>';
  		}
  		?>
  		<input type="text" name="login" placeholder="Login" spellcheck="false">
  		<input type="password" name="password" placeholder="Password">
  		<input type="submit" name="signin" value="Sign in">
  		<a href="#" style="visibility: hidden;">Forgot Password?</a>
  		<a href="/register.php" style="text-align: right;">Create account</a>
	</form>
</body>
</html>
