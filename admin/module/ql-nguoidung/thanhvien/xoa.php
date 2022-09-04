<?php
session_start();
$id_tv=$_GET['id_tv'];
include("../../../../connect.php");
$sql="DELETE FROM thanhvien WHERE id_tv='$id_tv'";
$rl=mysqli_query($conn,$sql);

$sqlCheck="SELECT * FROM thanhvien WHERE id_tv='$id_tv'";
$rlCheck=mysqli_query($conn,$sqlCheck);
$check=mysqli_num_rows($rlCheck);
if ($check > 0) {
	$_SESSION['error']='Xóa thất bại !';
	header("location:index.php");
	die();
}else{
	$_SESSION['success']='Xóa thành công !';
	header("location:index.php");
	die();
}

?>