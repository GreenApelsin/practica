<?php
require "config.php";
$configs = include('config.php');
$errors = array();

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
  		<h1>Registration</h1>
  		<?php 
  		if(!empty($errors)){
  			echo '<div class="errorlogin">'.array_shift($errors)'</div>';
  		}
  		?>
  		<input type="text" name="login" placeholder="Login" spellcheck="false">
  		<input type="text" name="email" placeholder="E-mail" spellcheck="false">
  		<input type="password" name="password" placeholder="Password">
  		<input type="password" name="password2" placeholder="Repeat password">
  		<input type="submit" name="signin" value="Create">
  		<a href="/" style="text-align: center; width: 260px;">Sign in</a>
	</form>
</body>
</html>
