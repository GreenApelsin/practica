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
		<form class="container" action="index.php" method="post">
	  		<?php 
	  		if(!empty($errors)){
	  			echo '<div class="errorlogin">'.array_shift($errors).'</div>';
	  		}
	  		?>
	  		<input type="text" name="name" placeholder="Name file" spellcheck="false">
	  		<input type="file" name="file">

	  		<?php 
	  		$mysql = new mysqli($configs['localhost'], $configs['username'], $configs['password'], $configs['dbname']);
	  		$cursor = $mysql->query("SELECT `login` FROM `user`;");
			echo '<select name="select"><option selected="selected">Selected user</option>';
			while( $result = $cursor->fetch_assoc() ) { 
        		echo '<option>'.$result['login'].'</option>';
        	}
      		echo '</select>';
	  		$mysql->close();
	  		?>
	  		
	  		<input type="submit" name="send" value="Send">
	  		<a href="#" style="visibility: hidden;">Forgot Password?</a>
	  		<a href="/register.php" style="text-align: right;">Create account</a>
		</form>
		</div>
	</div>
</body>
</html>