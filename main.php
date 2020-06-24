<?php 
$configs = include('config.php');
$errors = array();

if(!isset($_SESSION['logged_user'])){
	header("Location: /");
}

echo '<a href="/logout.php">Выход</a>';

?>

<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
	<title>Главная</title>
</head>
<body>
	<div class="container">
		<div class="right">
			<ui>
				<li class="menu">Menu</li>
				<li class="activ"><a href="/main.php">Main page</a></li>
				<li><a href="/send.php">Send file</a></li>
				<li><a href="/my.php">My files</a></li>
				<li><a href="/received.php">Received file</a></li>
			</ui>
		</div>
	</div>
</body>
</html>
