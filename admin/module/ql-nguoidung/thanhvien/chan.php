<?php
session_start();
include("../../../../connect.php");
$id_tv=$_GET['id_tv'];
$sql="SELECT * FROM thanhvien WHERE id_tv='$id_tv'";
$rl=mysqli_query($conn,$sql);
$data=mysqli_fetch_assoc($rl);
$trangthai_tv=$data['trangthai_tv']==0 ? '1' : '0';
$sql1="UPDATE thanhvien SET trangthai_tv='$trangthai_tv' WHERE id_tv=$id_tv";
$rl1=mysqli_query($conn,$sql1);
$_SESSION['success']='Thay đổi trạng thái thành viên thành công !';
header("location:index.php");
die();
?>