<?php 
$configs = include('config.php');
unset($_SESSION['logged_user']);
header("Location: /");
?>