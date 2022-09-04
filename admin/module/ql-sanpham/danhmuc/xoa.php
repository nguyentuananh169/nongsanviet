<?php
session_start();
$id_dmsp=$_GET['id_dmsp'];
include("../../../../connect.php");
$sqlCheck="SELECT * FROM sanpham WHERE id_dmsp='$id_dmsp'";
$rlCheck=mysqli_query($conn,$sqlCheck);
$check=mysqli_num_rows($rlCheck);
if ($check>0) {
	$_SESSION['error']='Lỗi ! Không thể xóa vì danh mục này còn sản phẩm ! Bạn hãy xóa sản phẩm của danh mục này trước';
	header("location:index.php");
	die();
}
$sql="DELETE FROM danhmuc_sp WHERE id_dmsp='$id_dmsp'";
$rl=mysqli_query($conn,$sql);
$_SESSION['success']='Xóa thành công !';
header("location:index.php");
die();
?>