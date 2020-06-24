<?php 
$configs = include('config.php');
$errors = array();

if(!isset($_SESSION['logged_user'])){
	header("Location: /");
}

echo "ok";

?>
<a href="/logout.php">Выход</a>