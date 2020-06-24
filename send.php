<?php 
$configs = include('config.php');
$errors = array();
$data = $_POST;
var_dump($_FILES['upload']);
var_dump($data['upload']);
if(!isset($_SESSION['logged_user'])){
	header("Location: /");
}

if (isset($data['send'])) {
	if(trim($data['name']) == ''){
		$errors[] = "File name can't be empty";
	}
	if(trim($data['select']) == ''){
		$errors[] = "Selected user can't be empty";
	}
	if (isset($_FILES['upload'])) {
		echo "string";
		move_uploaded_file($_FILES['upload']['tmp_name'], "file/".$_FILES['upload']['name']);
		echo "string";
	}else{
		$errors[] = "File can't be empty";
	}
	

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

		<form action="send.php" method="post">
	  		<?php 
	  		if(!empty($errors)){
	  			echo '<div class="errorSend">'.array_shift($errors).'</div>';
	  		}
	  		?>
	  		<input type="text" name="name" placeholder="File name" spellcheck="false" value="<?php if(!$regok){echo @$data['name'];} ?>">

	  		<?php 
	  		$mysql = new mysqli($configs['localhost'], $configs['username'], $configs['password'], $configs['dbname']);
	  		$cursor = $mysql->query("SELECT `login` FROM `user`;");
			echo '<select name="select"><option selected="true" disabled="disabled">Selected user</option>';
			while( $result = $cursor->fetch_assoc() ) { 
        		echo '<option>'.$result['login'].'</option>';
        	}
      		echo '</select>';
	  		$mysql->close();
	  		?>
	  		
	  		<input type="submit" name="send" value="Send">
	  		<div class="filesend">
	  			<input type="file" title=" " name="upload" id="upload" onchange="getName(this.value);" />
	  			<div id="fileformlabel">Выбери или перетащи</div>
	  		</div>
		</form>

		</div>
	</div>
	<script>
		function getName (str){
    		if (str.lastIndexOf('\\')){
        		var i = str.lastIndexOf('\\')+1;
    		}
    		else{
    				var i = str.lastIndexOf('/')+1;
    		}						

    		if (i == 0){
    			var filename = "Выбери или перетащи";
    		}else{
    			var filename = str.slice(i);
    		}			
    		var uploaded = document.getElementById("fileformlabel");
    		uploaded.innerHTML = filename;
		}
  	</script>
</body>
</html>