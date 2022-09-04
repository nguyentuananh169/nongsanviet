<?php
session_start();
$id_tt=$_GET['id_tt'];
include("../../../../connect.php");
$sqlCheck="SELECT * FROM sanpham WHERE id_tt='$id_tt'";
$rlCheck=mysqli_query($conn,$sqlCheck);
$check=mysqli_num_rows($rlCheck);
if ($check>0) {
	$_SESSION['error']='Lỗi ! Không thể xóa vì thuộc tính này còn sản phẩm ! Bạn hãy xóa sản phẩm của thuộc tính này trước';
	header("location:index.php");
	die();
}
$sql="DELETE FROM thuoctinh WHERE id_tt='$id_tt'";
$rl=mysqli_query($conn,$sql);
$_SESSION['success']='Xóa thành công !';
header("location:index.php");
die();
?>