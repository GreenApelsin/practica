<?php
require "config.php";
$configs = include('config.php');
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
	$mysql = new mysqli($configs['localhost'], $configs['username'], $configs['password'], $configs['dbname']);
	$cursor = $mysql->query("SELECT * FROM `user` WHERE `id` = '1'");
	$result = $cursor->fetch_assoc();
	echo "string".$result['name'];
	$mysql->close();
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
  		?>
  		<input type="text" name="login" placeholder="Login" spellcheck="false" value="<?php echo @$data['login']; ?>">
  		<input type="text" name="email" placeholder="E-mail" spellcheck="false" value="<?php echo @$data['email']; ?>">
  		<input type="password" name="password" placeholder="Password">
  		<input type="password" name="password2" placeholder="Repeat password">
  		<input type="submit" name="create" value="Create">
  		<a href="/" style="text-align: center; width: 260px;">Sign in</a>
	</form>
</body>
</html>
