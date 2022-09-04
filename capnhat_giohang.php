<?php
session_start();
include("connect.php");
$id_sp=$_POST['id_sp'];
$qty=$_POST['qty'];

if (!isset($_SESSION['cart'])) {
	echo "<script>alert('Lỗi ! Bạn chưa có sản phẩm nào trong giỏ hàng!'),location.href='dangnhap.php'</script>";
		die();
}

if (isset($_POST['btn-update-qty'])){
	if ($qty==""){
		echo "<script>alert('Lỗi ! Bạn chưa nhập số lượng mua !'),location.href='giohang.php'</script>";
		die();
	}

	if ($qty<=0){
		echo "<script>alert('Lỗi ! Số lượng bạn nhập phải lớn hơn 0 !'),location.href='giohang.php'</script>";
		die();
	}
		
	$sql="SELECT * FROM sanpham WHERE id_sp='$id_sp'";
	$rl=mysqli_query($conn,$sql);
	$sanpham=mysqli_fetch_assoc($rl);
	if ($qty>$sanpham['soluong']) {
		echo "<script>alert('Lỗi ! Số lượng bạn nhập đạt quá mức trong kho !'),location.href='giohang.php'</script>";
		die();
	}else{
		$_SESSION['cart'][$id_sp]['qty']=$qty;
		echo "<script>alert('Cập nhật số lượng thành công !'),location.href='giohang.php'</script>";
		die();
	}
	
}else{
	$_SESSION['error']='Bạn hãy nhấn nút Cập nhật !';
		header("location:giohang.php");
		die();
}
?>