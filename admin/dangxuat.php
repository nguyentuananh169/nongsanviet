<?php
session_start();
if (!isset($_SESSION['admin'])) {
	header("location:dangnhap.php");
	die();
}else{
	unset($_SESSION['admin']);
	header("location:dangnhap.php");
	die();
}
?>