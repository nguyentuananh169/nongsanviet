<?php
session_start();
$id_dmsp=$_GET['id_dmsp'];
include("../../../../connect.php");
$sql="SELECT * FROM danhmuc_sp WHERE id_dmsp='$id_dmsp'";
$rl=mysqli_query($conn,$sql);
$data=mysqli_fetch_assoc($rl);
$trangthai=isset($data['trangthai']) && $data['trangthai'] == 0 ? 1 : 0 ;
$sql2="UPDATE danhmuc_sp SET trangthai='$trangthai' WHERE id_dmsp='$id_dmsp'";
$rl2=mysqli_query($conn,$sql2);
$_SESSION['success']='Cập nhật trạng thái danh mục "'.$data['ten_dmsp'].'" thành công !';
header("location:index.php");
die();
?>