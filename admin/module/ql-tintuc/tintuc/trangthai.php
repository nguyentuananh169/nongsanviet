<?php
session_start();
$id_tt=$_GET['id_tt'];
include("../../../../connect.php");
$sql="SELECT * FROM tintuc WHERE id_tt='$id_tt'";
$rl=mysqli_query($conn,$sql);
$data=mysqli_fetch_assoc($rl);
$trangthai=isset($data['trangthai_tt']) && $data['trangthai_tt'] == 0 ? 1 : 0 ;
$sql2="UPDATE tintuc SET trangthai_tt='$trangthai' WHERE id_tt='$id_tt'";
$rl2=mysqli_query($conn,$sql2);
$_SESSION['success']='Cập nhật trạng thái tin tức thành công !';
header("location:index.php");
die();
?>