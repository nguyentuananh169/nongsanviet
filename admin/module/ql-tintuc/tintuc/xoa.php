<?php
session_start();
$id_tt=$_GET['id_tt'];
include("../../../../connect.php");
$sql="DELETE FROM tintuc WHERE id_tt='$id_tt'";
$rl=mysqli_query($conn,$sql);
$_SESSION['success']='Xóa thành công !';
header("location:index.php");
die();
?>