<?php 
$configs = include('config.php');
$errors = array();

if(!isset($_SESSION['logged_user'])){
	header("Location: /");
}

if ($_GET['del'] != ''){
	$mysql = new mysqli($configs['localhost'], $configs['username'], $configs['password'], $configs['dbname']);
	$mysql->query("DELETE FROM `infofiles` WHERE `name` = '".$_GET['del']."';");
	$_SESSION['delok'] = true;
	header("Location: /my");
	exit();
}

?>

<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
	<title>My files</title>
</head>
<body>
	<div class="container">
		<div class="left">
			<ui>
				<li class="menu">Menu</li>
				<li><a href="/main">Main page</a></li>
				<li><a href="/send">Send file</a></li>
				<li class="activ"><a href="/my">My files</a></li>
				<li><a href="/received">Received file</a></li>
				<li class="end"><a href="/logout">Log out</a></li>
			</ui>
		</div>
		<div class="right">
			<h1>My files</h1>
			<?php 
	  		if($_SESSION['delok']){
  				echo '<div class="errorSend" style="color: #53B82D">File deleted</div>';
  				unset($_SESSION['delok']);
  			}
	  		?>
			<table>
				<tr class="trtit">
					<th>Delete?</th>
					<th>File name</th>
				</tr>
				<?php
				$mysql = new mysqli($configs['localhost'], $configs['username'], $configs['password'], $configs['dbname']);
				$cursor = $mysql->query("SELECT `login`, `real-name`, `name` FROM `infofiles`, `user` WHERE `infofiles`.`author-id` = `user`.`id` AND `author-id` = '".$_SESSION['logged_user']['id']."' ORDER BY `infofiles`.`id` DESC;");
				$flagg = true;
				//узнаем сколько строк нам возвращено
				while( $result = $cursor->fetch_assoc() ) { 
					if ($flagg){
						echo '<tr><td>';
					}else{
						echo '<tr class="tr2"><td>';
					}
        			echo '<a href="?del='.$result['name'].'">Delete</a></td><td><a href="/save?f='.$result['name'].'">'.$result['real-name'].'</a></td></tr>';
        			$flagg = !$flagg;
        		}
				$mysql->close();
				?>
			</table>
		</div>
	</div>
</body>
</html>
