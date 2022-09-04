<?php
session_start();
include("../../../../connect.php");
$id_sp=$_GET['id_sp'];
$sql="SELECT * FROM sanpham WHERE id_sp='$id_sp'";
$rl=mysqli_query($conn,$sql);
$data=mysqli_fetch_assoc($rl);
$noibat=$data['noibat']==0 ? 1 : 0;
$sqlUpdate="UPDATE sanpham SET noibat='$noibat' WHERE id_sp='$id_sp'";
$rlUpdate=mysqli_query($conn,$sqlUpdate);
$_SESSION['success']='Thay đổi sản phẩm " '.$data['ten_sp'].' " thành công !';
header("location:index.php");
die();
?>