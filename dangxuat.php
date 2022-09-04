<?php
session_start();
if (isset($_SESSION['user'])) {
	session_unset();
	header("location:index.php");
	die();
}else{
	header("location:index.php");
	die();
}
?>