<?php 
$configs = include('config.php');
$errors = array();

if(!isset($_SESSION['logged_user'])){
	header("Location: /");
}

?>

<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
	<title>Send File</title>
</head>
<body>
	<div class="container">
		<div class="left">
			<ui>
				<li class="menu">Menu</li>
				<li><a href="/main.php">Main page</a></li>
				<li class="activ"><a href="/send.php">Send file</a></li>
				<li><a href="/my.php">My files</a></li>
				<li><a href="/received.php">Received file</a></li>
				<li class="end"><a href="/logout.php">Log out</a></li>
			</ui>
		</div>
		<div class="right">
			<h1>Send file</h1>
		</div>
	</div>
</body>
</html>