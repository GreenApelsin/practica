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
			
			<a href="/main.php">Main page</a>
			<a href="/send.php">Send file</a>
			<a href="/my.php">My files</a>
			<a href="/received.php">Received file</a>
			
		</div>
	</div>
</body>
</html>
