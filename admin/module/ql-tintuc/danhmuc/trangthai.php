<?php
session_start();
$id_dmtt=$_GET['id_dmtt'];
include("../../../../connect.php");
$sql="SELECT * FROM danhmuc_tintuc WHERE id_dmtt='$id_dmtt'";
$rl=mysqli_query($conn,$sql);
$data=mysqli_fetch_assoc($rl);
$trangthai=isset($data['trangthai']) && $data['trangthai'] == 0 ? 1 : 0 ;
$sql2="UPDATE danhmuc_tintuc SET trangthai='$trangthai' WHERE id_dmtt='$id_dmtt'";
$rl2=mysqli_query($conn,$sql2);
$_SESSION['success']='Cập nhật trạng thái danh mục "'.$data['ten_dmtt'].'" thành công !';
header("location:index.php");
die();
?>