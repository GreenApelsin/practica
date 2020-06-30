<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../support/css/style.css">
	<link rel="stylesheet" type="text/css" href="../support/css/login.css">
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
	<title>Авторизация</title>
</head>
<body>
	<form class="container" action="login" method="post" id="authID">
  		<h1>Sign in to your account</h1>
  		<?php
  		if(!empty($errors)){
  			echo '<div class="errorLogin">'.array_shift($errors).'</div>';
  		}
  		?>
  		<input type="text" name="login" placeholder="Login" spellcheck="false" value="<?php if(!isset($_SESSION['logged_user'])) echo @$_POST['login']; ?>">
  		<input type="password" name="password" placeholder="Password">
  		<input type="submit" name="signin" value="Sign in">
  		<a href="#" style="visibility: hidden;">Forgot Password?</a>
  		<a href="/register" style="text-align: right;">Create account</a>
	</form>
</body>
</html>
