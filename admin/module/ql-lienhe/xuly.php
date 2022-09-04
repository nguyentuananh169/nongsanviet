<?php 
session_start();
include("../../../connect.php");
$id_lh=$_GET['id_lh'];
$sql="UPDATE lienhe SET trangthai = 1 WHERE id_lh = '$id_lh'";
$rl=mysqli_query($conn,$sql);
$_SESSION['success']='Thay đổi trạng thái mã liên hệ "'.$id_lh.'" thành công';
header("location:index.php");
?>