<?php
session_start();
if (!isset($_SESSION['cart'])) {
	echo "<script>alert('Lỗi ! Bạn chưa có sản phẩm nào trong giỏ hàng!'),location.href='dangnhap.php'</script>";
		die();
}

$id_sp = $_GET['id_sp'];
unset($_SESSION['cart'][$id_sp]);

if (isset($_SESSION['cart'][$id_sp])) {
	echo "<script>alert('Xoá sản phẩm trong giỏ hàng thất bại !'),location.href='giohang.php'</script>";
	die();
}else{
	echo "<script>alert('Xoá sản phẩm trong giỏ hàng thành công !'),location.href='giohang.php'</script>";
	die();
}
?>