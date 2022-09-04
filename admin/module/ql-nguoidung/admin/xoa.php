<?php
session_start();
$open='ql-nguoidung';
include("../../../../connect.php");
$get_id_ad = $_GET['id_ad'];

$sqlDelete="DELETE FROM admin WHERE id_ad = '$get_id_ad'";
$rlDelete=mysqli_query($conn,$sqlDelete);

$_SESSION['success']='Xóa thành công !';
header("location:index.php");
die();

?>