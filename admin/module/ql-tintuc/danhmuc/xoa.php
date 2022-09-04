<?php
session_start();
$id_dmtt=$_GET['id_dmtt'];
include("../../../../connect.php");
$sqlCheck="SELECT * FROM tintuc WHERE id_dmtt='$id_dmtt'";
$rlCheck=mysqli_query($conn,$sqlCheck);
$check=mysqli_num_rows($rlCheck);
if ($check>0) {
	$_SESSION['error']='Lỗi ! Không thể xóa vì danh mục này còn bài viết ! Bạn hãy xóa bài viết của danh mục này trước';
	header("location:index.php");
	die();
}
$sql="DELETE FROM danhmuc_tintuc WHERE id_dmtt='$id_dmtt'";
$rl=mysqli_query($conn,$sql);
$_SESSION['success']='Xóa thành công !';
header("location:index.php");
die();
?>