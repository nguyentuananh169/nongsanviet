<?php
session_start();
include("connect.php");
include("library/function.php");
?>
<?php include("layout/header.php") ?>
<div class="container">
	<div class="wide">
		<div class="path">
			<ul>
				<li><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Trang chủ</a></li>
				<li><a href="">Kiểm tra đơn hàng</a></li>
			</ul>
		</div>
		<div class="form-check-order">
			<form action="ct_donhang.php" method="get">
				<h3>Kiểm tra đơn hàng của bạn</h3>
				<div class="input-check-order">
					<input type="text" name="id_dh" placeholder="Vui lòng nhập mã đơn hàng ...">
				</div>
				<div class="btn-check-order">
					<button type="submit" name="btn-submit">Tra cứu</button>
				</div>
			</form>
			<div class="you-know">
				<div class="text">
					<strong>Đăng nhập sẽ giúp bạn quản lý đơn hàng của mình và trải nghiệm Website tốt hơn</strong>
					<a href="dangnhap.php" class="link-login"><strong>Đăng nhập</strong></a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include("layout/footer.php") ?>