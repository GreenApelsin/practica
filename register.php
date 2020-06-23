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
  		<input type="text" name="login" placeholder="E-mail" spellcheck="false">
  		<input type="password" name="password" placeholder="Password">
  		<input type="submit" name="signin" value="Sign in">
  		<a href="#" style="visibility: hidden;">Forgot Password?</a>
  		<a href="/registr.php" style="text-align: right;">Create account</a>
	</form>
</body>
</html>
