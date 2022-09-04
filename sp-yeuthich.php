<?php 
session_start();
include("connect.php");
$get_id_sp=$_GET['id_sp'];
$get_id_dmsp=$_GET['id_dmsp'];
if (!isset($_SESSION['user'])) {
	echo "<script>alert('Lỗi ! Bạn phải đăng nhập mới có thể sử dụng chức năng này !'),location.href='dangnhap.php'</script>";
	die();
}

$sql = "SELECT * FROM sanpham_yt WHERE id_sp='$get_id_sp' AND id_tv=".$_SESSION['user'];
$rl = mysqli_query($conn,$sql);
$num = mysqli_num_rows($rl);

if ($num > 0) {
	$sqlDelete = "DELETE FROM sanpham_yt WHERE id_sp='$get_id_sp' AND id_tv=".$_SESSION['user'];
	$rlDelete = mysqli_query($conn,$sqlDelete);
	echo "<script>alert('Xóa sản phẩm khỏi danh sách yêu thích thành công !'),location.href='chitietsp.php?id_sp=".$get_id_sp."&id_dmsp=".$get_id_dmsp."'</script>";
	die();
}else{
	$sqlInsert = "INSERT INTO sanpham_yt(id_sp,id_tv) VALUES('$get_id_sp','".$_SESSION['user']."')";
	$rlInsert = mysqli_query($conn,$sqlInsert);
	echo "<script>alert('Thêm sản phẩm vào danh sách yêu thích thành công !'),location.href='chitietsp.php?id_sp=".$get_id_sp."&id_dmsp=".$get_id_dmsp."'</script>";
	die();
}
?>