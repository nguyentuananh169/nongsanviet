<?php 
session_start();
include("connect.php");
if (!isset($_SESSION['user'])) {
	echo "<script>alert('Lỗi ! Bạn phải đăng nhập mới có thể sử dụng chức năng này !'),location.href='dangnhap.php'</script>";
	die();
}
if (isset($_POST['btn-submit'])) {
	$id_sp=$_POST['id_sp'];
	$qty=$_POST['qty'];

	$sql="SELECT * FROM sanpham 
	INNER JOIN thuoctinh ON sanpham.id_tt = thuoctinh.id_tt 
	WHERE id_sp='$id_sp'";
	$rl=mysqli_query($conn,$sql);
	$sanpham=mysqli_fetch_assoc($rl);

	if ($sanpham['soluong'] <= 0) {
		echo "<script>alert('Sản phẩm đã hết hàng ! Chúng tôi sẽ sớm cập nhật thêm trong thời gian sớm nhất'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	if ($qty == "") {
		echo "<script>alert('Lỗi ! Bạn chưa nhập số lượng mua !'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	if ($qty <= 0) {
		echo "<script>alert('Lỗi ! Số lượng bạn nhập phải lớn hơn 0 !'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	if ($qty > $sanpham['soluong']) {
		echo "<script>alert('Lỗi ! Số lượng bạn nhập đã đạt quá mức trong kho!'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	if (isset($_SESSION['cart'][$id_sp])) {
		$_SESSION['cart'][$id_sp]['qty']+=$qty;
	}else{
		$_SESSION['cart'][$id_sp]['name']=$sanpham['ten_sp'];
		$_SESSION['cart'][$id_sp]['price']=$sanpham['gia'];
		$_SESSION['cart'][$id_sp]['qty']=$qty;
		$_SESSION['cart'][$id_sp]['hinhanh']=$sanpham['hinhanh'];
		$_SESSION['cart'][$id_sp]['thuoctinh']=$sanpham['ten_tt'];
	}

}
echo "<script>alert('Thêm sản phẩm vào giỏ hàng thành công !'),location.href='giohang.php'</script>";
die();
?>