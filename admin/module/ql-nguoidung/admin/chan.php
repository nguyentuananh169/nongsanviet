<?php
session_start();
include("../../../../connect.php");
$id_ad=$_GET['id_ad'];

$sql="SELECT * FROM admin WHERE id_ad='$id_ad'";
$rl=mysqli_query($conn,$sql);
$data=mysqli_fetch_assoc($rl);

$trangthai_ad=$data['trangthai_ad']==0 ? '1' : '0';

$sql1="UPDATE admin SET trangthai_ad='$trangthai_ad' WHERE id_ad=$id_ad";
$rl1=mysqli_query($conn,$sql1);

$_SESSION['success']='Thay đổi trạng thái admin thành công !';
header("location:index.php");
die();
?>