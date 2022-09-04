<div class="container hd-tablet">
	<div class="wide">
		<div class="header-tablet">
			<div class="bars-tablet">
				<i class="fa fa-bars"></i>
			</div>
			<div class="logo-tablet">
				<a href="<?php echo base_url() ?>">
					<img src="<?php echo base_url() ?>/img/icon/logo.png">
				</a>
			</div>
			<div class="order-tablet">
				<a href="<?php echo base_url() ?>/giohang.php">
					<div class="check-cart">
						<span class="icon">
							<i class="fa fa-shopping-bag"></i>
							<span class="number"><?php echo count($_SESSION['cart']) ?></span>
						</span>
					</div>
				</a>
			</div>
			<div class="search-tablet">
				<form action="<?php echo base_url() ?>/timkiem.php" method="get">
					<input type="text" name="keyword" placeholder="Nhập từ khóa hoặc tên sản phẩm..." value="<?php echo $keyword ?>">
					<button type="submit" name="btn-search">
						<i class="fa fa-search"></i>
					</button>
				</form>
			</div>
		</div>
		<div class="overlay-nav-menu"></div>
		<div class="nav-menu-tablet">
			<div class="menu-container">
				<div class="close-menu">
					<i class="fa fa-times"></i>
				</div>
				<div class="user-info">
					<div class="user-avatar">
						<img src="<?php echo base_url() ?>/img/icon/no-avt.png" alt="">
					</div>
					<div class="user-name">
						<ul>
							<?php if (isset($_SESSION['user'])) : ?>
							<li><a href="<?php echo base_url() ?>/thongtin">Tài khoản</a></li>
							<li><a href="<?php echo base_url() ?>/thongtin">Xin chào: <?php echo $user['ten_tv']; ?></a></li>
							<?php else: ?>
							<li><a href="<?php echo base_url() ?>/dangnhap.php">Đăng nhập</a></li>
							<li><a href="<?php echo base_url() ?>/dangky.php">Đăng ký</a></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
				<ul>
					<li class="border <?php echo isset($open) && $open == 'trangchu' ? 'active' : '' ?>">
						<a href="">Trang chủ</a>
					</li>

					<?php
						$sql="SELECT * FROM danhmuc_sp";
						$rl=mysqli_query($conn,$sql);
						while ($row=mysqli_fetch_assoc($rl)) {
							$id_dmsp=$row['id_dmsp'];
							$ten_dmsp=$row['ten_dmsp'];
					?>

					<li class="border <?php echo isset($open) && $open==$id_dmsp ? 'active' : '' ?>">
						<a href="<?php echo base_url() ?>/danhmucsp.php?id_dmsp=<?php echo $id_dmsp ?>">
							<?php echo $ten_dmsp ?>
						</a>
					</li>

					<?php } ?>

					<li class="border <?php echo isset($open) && $open=='tintuc' ? 'active' : '' ?>"><a href="<?php echo base_url() ?>/tintuc/">Tin tức</a></li>
					<li class="border <?php echo isset($open) && $open=='lienhe' ? 'active' : '' ?>"><a href="<?php echo base_url() ?>/lienhe.php">Liên hệ</a></li>
					<li><a href="<?php echo base_url() ?>/gioithieu.php">Giới thiệu</a></li>
					<li><a href="">Hệ thống siêu thị</a></li>
					<li><a href="">Tuyển dụng</a></li>
					<?php if (isset($_SESSION['user'])) : ?>
					<li><a href="<?php echo base_url() ?>/thongtin/donhang.php">Kiểm tra đơn hàng</a></li>
					<?php endif; ?>
					<li><a href="<?php echo base_url() ?>/kt_donhang.php">Kiểm tra đơn hàng</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>