<?php
session_start();
include("library/function.php");
include("connect.php");
if (!isset($_SESSION['user'])) {
	echo "<script>alert('Lỗi ! Bạn phải đăng nhập mới có thể sử dụng chức năng này !'),location.href='dangnhap.php'</script>";
		die();
}
if (count($_SESSION['cart']) == 0) {
	echo "<script>alert('Lỗi ! Bạn chưa có sản phẩm nào trong giỏ hàng để thanh toán !'),location.href='index.php'</script>";
		die();
}

$sqlTV="SELECT * FROM thanhvien WHERE id_tv=".$_SESSION['user'];
$rlTV=mysqli_query($conn, $sqlTV);
$user=mysqli_fetch_assoc($rlTV);

if (isset($_POST['btn-order'])) {
	$ten=$_POST['ten'];
	$email=$_POST['email'];
	$sdt=$_POST['sdt'];
	$diachi=$_POST['diachi'];
	$ghichu=$_POST['ghichu'];
	if ($ten=="" || $email=="" || $sdt=="" || $diachi=="") {
		echo "<script>alert('Lỗi ! Bạn chưa nhập đủ thông tin !'),location.href='javascript:history.go(-1)'</script>";
		die();
	}
	$sqlDH="INSERT INTO donhang(id_tv,ten_kh,email_kh,sdt_kh,diachi_kh,ghichu_kh,tongtien) VALUES('".$_SESSION['user']['id_tv']."','$ten','$email','$sdt','$diachi','$ghichu','".$_SESSION['TTthanhtoan']."')";
	$rlDH=mysqli_query($conn,$sqlDH);

	$id_insert=mysqli_insert_id($conn);

	foreach ($_SESSION['cart'] as $key => $value) {
		$thanhtien=$value['price'] * $value['qty'];
		$sqlDHSP="
	    INSERT INTO donhang_sp(id_dh,id_sp,ten_dhsp,thuoctinh,gia_dhsp,hinhanh_dhsp,qty_dhsp,thanhtien_dhsp) 
	    VALUES('$id_insert','$key','".$value['name']."','".$value['thuoctinh']."','".$value['price']."','".$value['hinhanh']."','".$value['qty']."','$thanhtien')";
	    $rlDHSP=mysqli_query($conn,$sqlDHSP);
	    /*Xem số lượng sản phẩm hiện tại*/
	    $sqlSP="SELECT * FROM sanpham WHERE id_sp='$key'";
	    $rlSP=mysqli_query($conn,$sqlSP);
	    $sanpham=mysqli_fetch_assoc($rlSP);
	    /*cập nhật lại số lượng sản phẩm trong database*/
	    $tru_soluong=$sanpham['soluong']-$value['qty'];
	    $buyed=$sanpham['buyed']+$value['qty'];
	    $sqlUpdateSL="UPDATE sanpham SET soluong='$tru_soluong',buyed='$buyed' WHERE id_sp='$key'";
	    $rlUpdateSL=mysqli_query($conn,$sqlUpdateSL);
	}
	if ($id_insert>0) {
		unset($_SESSION['cart']);
		unset($_SESSION['TTthanhtoan']);
		echo "<script>alert('Đơn hàng đặt thành công ! Chúng tôi sẽ liên hệ với bạn qua email và số điện thọai sau 5 phút đến 10 phút nữa ! Ấn Ok để về trang chủ'),location.href='index.php'</script>";
		die();
	}else{
		echo "<script>alert('Lỗi !'),location.href='giohang.php'</script>";
		die();
	}
}
?>
<?php include("layout/header.php") ?>
<div class="container">
	<div class="wide">
		<div class="path">
			<ul>
				<li><a href="<?php echo base_url() ?>">Trang chủ</a></li>
				<li><a href="giohang.php">Giỏ hàng</a></li>
				<li><a href="">Thanh toán</a></li>
			</ul>
		</div>
		<div class="form-order">
			<form action="" method="post">
				<div class="customer-detail">
					<h3>Thông tin thanh toán</h3>
					<p>Lưu ý: không được để trống !</p>
					<div class="form-row">
						<input type="text" name="ten" placeholder="Họ tên ..." value="<?php echo $user['ten_tv'] ?>">
					</div>
					<div class="form-row">
						<input type="text" name="email" placeholder="Email ..." value="<?php echo $user['email_tv'] ?>">
					</div>
					<div class="form-row">
						<input type="number" name="sdt" placeholder="Số điện thọai ..." value="<?php echo $user['sdt_tv'] ?>">
					</div>
					<div class="form-row">
						<input type="text" name="diachi" placeholder="Đia chi ..." value="<?php echo $user['diachi_tv'] ?>">
					</div>
					<div class="form-row">
						<textarea name="ghichu" maxlength="100" placeholder="Ghi chú (nếu cần) tối đa 100 ký tự"></textarea>
					</div>
				</div>
				<div class="order-detail">
					<h3>Đơn hàng của bạn</h3>
					<div class="order-review">
						<strong>Sản phẩm</strong>
						<strong>Tạm tính</strong>
					</div>
					<?php foreach ($_SESSION['cart'] as $key => $value) :?>
					<div class="order-review">
						<span><?php echo $value['name']; ?> / <?php echo $value['thuoctinh'] ?> x <?php echo $value['qty']; ?></span>
						<span>
							<?php 
							$TTsanpham = $value['price'] * $value['qty'];
								echo number_format($TTsanpham); 
							?>đ
						</span>
					</div>
					<?php 
					    $TTthanhtoan+=$TTsanpham;
					    $_SESSION['TTthanhtoan']=$TTthanhtoan;
				        endforeach; 
				    ?>
					<div class="order-review">
						<strong>Tổng tiền sản phẩm</strong>
						<span><?php echo number_format($_SESSION['TTthanhtoan']); ?>đ</span>
					</div>
					<div class="order-review">
						<strong>Giao hàng</strong>
						<span>Giao hàng miễn phí</span>
					</div>
					<div class="order-review">
						<strong>Tổng thanh toán</strong>
						<span><?php echo number_format($TTthanhtoan); ?>đ</span>
					</div>
					<div class="order-review">
						<strong>Hình thức thanh toán</strong>
						<span>Thanh toán khi nhận hàng</span>
					</div>
					<button type="submit" name="btn-order">Thanh toán</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include("layout/footer.php") ?>