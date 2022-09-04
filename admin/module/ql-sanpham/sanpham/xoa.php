<?php
session_start();
$open="QLsanpham";
$id_sp=$_GET['id_sp'];
include("../../../../connect.php");
/*Xóa sản phẩm theo id_sp*/
$sql="DELETE FROM sanpham WHERE id_sp='$id_sp'";
$rl=mysqli_query($conn,$sql);
/*ktra xem sản phẩm đã xóa hay chưa*/
$sql2="SELECT * FROM sanpham WHERE id_sp='$id_sp'";
$rl2=mysqli_query($conn,$sql2);
$check=mysqli_num_rows($rl2);
if ($check>0) {
	$_SESSION['error']='Xóa sản phẩm thất bại !';
    header("location:index.php");
    die();
}else{
	$_SESSION['success']='Xóa sản phẩm thành công !';
    header("location:index.php");
    die();
}
?>