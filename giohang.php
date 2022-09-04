<?php
session_start();
include("library/function.php");
include("connect.php");
if (!isset($_SESSION['user'])) {
	echo "<script>alert('Lỗi ! Bạn phải đăng nhập mới có thể sử dụng chức năng này !'),location.href='dangnhap.php'</script>";
		die();
}
?>
<?php include("layout/header.php") ?>
<div class="container">
	<div class="wide">
		<div class="path">
			<ul>
				<li><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Trang chủ</a></li>
				<li><a href="">Giỏ hàng</a></li>
			</ul>
		</div>
		<div class="cart">
			<h3>Bạn đang có <b><?php echo count($_SESSION['cart']); ?></b> sản phẩm trong giỏ hàng</a></h3>
			<div class="table-overflow">
				<table cellspacing="0" cellpadding="0">
					<tr>
						<th>#</th>
						<th>Tên sản phẩm</th>
						<th>Hình ảnh</th>
						<th>Đơn giá</th>
						<th>Số lượng/Thao tác</th>
						<th>Thành tiền (SL*G)</th>
					</tr>
					<?php $stt=1; 
					foreach ($_SESSION['cart'] as $key => $value) : ?>
					<tr>
						<td><?php echo $stt; ?></td>
						<td><?php echo $value['name']; ?></td>
						<td><img src="img/product/<?php echo $value['hinhanh']; ?>" width="50px" height="50px"></td>
						<td><?php echo number_format($value['price']); ?>đ/<?php echo $value['thuoctinh']; ?></td>
						<td>
							<form action="capnhat_giohang.php" method="post">
								<input type="number" name="id_sp" value="<?php echo $key; ?>" readonly hidden>
								<input type="number" name="qty" value="<?php echo $value['qty']; ?>">
								<button type="submit" name="btn-update-qty">Cập nhật</button>
								<a href="xoa_giohang.php?id_sp=<?php echo $key; ?>">Xóa</a>
							</form>
						</td>
						<td><?php $TTsanpham=$value['price'] * $value['qty'];echo number_format($TTsanpham); ?>đ</td>
					</tr>
					<?php 
					$stt++; 
					$TTthanhtoan+=$TTsanpham;
				    endforeach;
					?>
					<tr>
						<th colspan="6">Tổng tiền thanh toán <?php echo number_format($TTthanhtoan); ?>đ</th>
					</tr>
				</table>
			</div>
		</div>
		<div class="tool-cart">
			<a class="t1" href="thanhtoan.php"><i class="fa fa-shopping-bag"></i>Xác nhận và Đặt hàng</a>
			<a class="t2" href="index.php"><i class="fa fa-undo"></i>Tiếp tục mua hàng</a>
		</div>
	</div>
</div>
<?php include("layout/footer.php") ?>