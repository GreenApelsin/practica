<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../support/css/style.css">
	<link rel="stylesheet" type="text/css" href="../support/css/login.css">
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
	<title>Регистрация</title>
</head>
<body>
	<form class="container" action="register" method="post">
  		<h1>Registration</h1>
  		<?php 
  		if(!empty($errors)){
  			echo '<div class="errorLogin">'.array_shift($errors).'</div>';
  		}
  		if(isset($_SESSION['regok'])){
  			echo '<div class="errorLogin" style="color: #53B82D">Registration completed successfully</div>';
  			unset($_SESSION['regok']);
  		}
  		?>
  		<input type="text" name="login" placeholder="Login" spellcheck="false" value="<?php if(!isset($_SESSION['regok'])) echo @$_POST['login']; ?>">
  		<input type="text" name="email" placeholder="E-mail" spellcheck="false" value="<?php if(!isset($_SESSION['regok'])) echo @$_POST['email']; ?>">
  		<input type="password" name="password" placeholder="Password">
  		<input type="password" name="password2" placeholder="Repeat password">
  		<input type="submit" name="create" value="Create">
  		<a href="/" style="text-align: center; width: 260px;">Sign in</a>
	</form>
</body>
</html>
