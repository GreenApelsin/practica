<?php 
$configs = include('config.php');
$errors = array();

if(!isset($_SESSION['logged_user'])){
	header("Location: /index.php");
}

echo "ok";

?>