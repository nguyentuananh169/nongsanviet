<?php 
session_start();
include("../connect.php");
$sqlTV="SELECT * FROM thanhvien WHERE id_tv=".$_SESSION['user'];
$rlTV=mysqli_query($conn, $sqlTV);
$user=mysqli_fetch_assoc($rlTV);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Shop Nông sản Việt</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/style/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/style/css/base.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/style/css/tintuc.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/style/css/header-tablet.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/style/css/responsive.css">
	
</head>
<body>
	<div class="wrapper">
		<div class="header">
			<div class="top-header">
				<div class="wide">
					<ul class="top-navigation">
						<li class="li-lv1"><a class="link-lv1" href="<?php echo base_url() ?>/gioithieu.php">Giới thiệu</a></li>
						<li class="li-lv1"><a class="link-lv1" href="">Hệ thống siêu thị</a></li>
						<li class="li-lv1"><a class="link-lv1" href="">Tuyển dụng</a></li>

						<?php if (isset($_SESSION['user'])) : ?>
						<li class="li-lv1">
							<label for="user-dashboard" class="">Xin chào: <?php echo $user['ten_tv']; ?></label>
							<input type="checkbox" id="user-dashboard" hidden>
							<label for="user-dashboard" class="overlay"></label>
							<div class="show-dashboard">
								<ul>
									<li><a href="<?php echo base_url() ?>/thongtin">Thông tin tài khoản</a></li>
									<li><a href="<?php echo base_url() ?>/thongtin/donhang.php">Đơn hàng của bạn</a></li>
									<li><a href="<?php echo base_url() ?>/thongtin/sp-yeuthich.php">Sản phẩm yêu thích</a></li>
									<li><a href="<?php echo base_url() ?>/thongtin/ql-binhluan.php">Quản lý bình luận</a></li>
									<li class="b-t"><a href="<?php echo base_url() ?>/dangxuat.php">Đăng xuất</a></li>
								</ul>
							</div>
						</li>

						<?php else: ?>

						<li class="li-lv1"><a class="link-lv1" href="<?php echo base_url() ?>/dangnhap.php">Đăng nhập</a></li>
						<li class="li-lv1"><a class="link-lv1" href="<?php echo base_url() ?>/dangky.php">Đăng ký</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			<div class="container">
				<div class="wide">
					<div class="content-header">
						<div class="logo">
							<a href="<?php echo base_url() ?>">
								<img src="<?php echo base_url() ?>/img/icon/logo.png">
							</a>
						</div>
						<div class="search-box">
							<form action="<?php echo base_url() ?>/timkiem.php" method="get">
								<div class="search">
									<input type="text" name="keyword" placeholder="Nhập từ khóa hoặc tên sản phẩm..." value="<?php echo $keyword ?>">
									<button type="submit" name="btn-search"><i class="fa fa-search"></i></button>
								</div>
							</form>
						</div>
						<div class="order-tool">
							<?php if (isset($_SESSION['user'])) : ?>
							<a href="<?php echo base_url() ?>/thongtin/donhang.php">
								<div class="check-order">
									<span class="icon">
										<i class="fa fa-truck"></i>
									</span>
									<span class="text">Kiểm tra đơn hàng</span>
								</div>
							</a>
							<?php else: ?>
							<a href="<?php echo base_url() ?>/kt_donhang.php">
								<div class="check-order">
									<span class="icon">
										<i class="fa fa-truck"></i>
									</span>
									<span class="text">Kiểm tra đơn hàng</span>
								</div>
							</a>
							<?php endif; ?>
							
							<a href="<?php echo base_url() ?>/giohang.php">
								<div class="check-cart">
									<span class="icon">
										<i class="fa fa-shopping-bag"></i>
										<span class="number"><?php echo count($_SESSION['cart']) ?></span>
									</span>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="container my-header">
				<div class="wide">
					<div class="menu-header">
						<ul>
							<li class="<?php echo isset($open) && $open=='trangchu' ? 'active' : '' ?>">
								<a href="<?php echo base_url() ?>/">Trang chủ</a>
							</li>
							<?php
							$sql="SELECT * FROM danhmuc_sp";
							$rl=mysqli_query($conn,$sql);
							while ($row=mysqli_fetch_assoc($rl)) {
								$id_dmsp=$row['id_dmsp'];
								$ten_dmsp=$row['ten_dmsp'];
							
							?>
							<li class="<?php echo isset($open) && $open==$id_dmsp ? 'active' : '' ?>">
								<a href="<?php echo base_url() ?>/danhmucsp.php?id_dmsp=<?php echo $id_dmsp ?>"><?php echo $ten_dmsp; ?></a>
								<div class="dropdown-menu-header">
									<div class="sub">
										<div class="mn b-r">
											<h3>Sản phẩm bán chạy nhất</h3>
											<div class="item-mn">
												<?php
												$sql2="SELECT * FROM sanpham WHERE id_dmsp='$id_dmsp' AND buyed > 0 ORDER BY buyed DESC LIMIT 4";
												$rl2=mysqli_query($conn,$sql2);
												while ($row2=mysqli_fetch_assoc($rl2)) {
													$id_dmsp2=$row2['id_dmsp'];
													$id_sp2=$row2['id_sp'];
													$ten_sp2=$row2['ten_sp'];
													$hinhanh2=$row2['hinhanh'];
													$buyed2=$row2['buyed'];
												?>
												<div class="item-s">
													<div class="img-s">
														<a href="<?php echo base_url() ?>/chitietsp.php?id_sp=<?php echo $id_sp2; ?>&id_dmsp=<?php echo $id_dmsp2; ?>">
															<img src="<?php echo base_url() ?>/img/product/<?php echo $hinhanh2; ?>" width="50" height="50">
														</a>
													</div>
													<div class="name-s">
														<a href="<?php echo base_url() ?>/chitietsp.php?id_sp=<?php echo $id_sp2; ?>&id_dmsp=<?php echo $id_dmsp2; ?>">
															<?php echo $ten_sp2; ?> 
															(<?php echo $buyed2; ?>)
														</a>
													</div>
												</div>
												<?php } ?>
											</div>
										</div>
										<div class="mn b-r">
											<h3>Sản phẩm xem nhiều nhất</h3>
											<div class="item-mn">
												<?php
												$sql3="SELECT * FROM sanpham WHERE id_dmsp='$id_dmsp' ORDER BY view DESC LIMIT 4";
												$rl3=mysqli_query($conn,$sql3);
												while ($row3=mysqli_fetch_assoc($rl3)) {
													$id_dmsp3=$row3['id_dmsp'];
													$id_sp3=$row3['id_sp'];
													$ten_sp3=$row3['ten_sp'];
													$hinhanh3=$row3['hinhanh'];
													$view3=$row3['view'];
												?>
												<div class="item-s">
													<div class="img-s">
														<a href="<?php echo base_url() ?>/chitietsp.php?id_sp=<?php echo $id_sp3; ?>&id_dmsp=<?php echo $id_dmsp3; ?>">
															<img src="<?php echo base_url() ?>/img/product/<?php echo $hinhanh3; ?>" width="50" height="50">
														</a>
													</div>
													<div class="name-s">
														<a href="<?php echo base_url() ?>/chitietsp.php?id_sp=<?php echo $id_sp3; ?>&id_dmsp=<?php echo $id_dmsp3; ?>">
															<?php echo $ten_sp3; ?> 
															(<?php echo $view3; ?>)
														</a>
													</div>
												</div>
												<?php } ?>
											</div>
										</div>
										<div class="mn">
											<h3>Quan tâm nhất</h3>
											<div class="item-mn">
												<a href="">Hôm nay</a>
											</div>
											<div class="item-mn">
												<a href="">Tuần này</a>
											</div>
											<div class="item-mn">
												<a href="">Tháng này</a>
											</div>
											<div class="item-mn">
												<a href="">Năm nay</a>
											</div>
										</div>
									</div>
								</div>
							</li>
							<?php } ?>
							<li class="<?php echo isset($open) && $open=='tintuc' ? 'active' : '' ?>"><a href="<?php echo base_url() ?>/tintuc/">Tin tức</a></li>
							<li class="<?php echo isset($open) && $open=='lienhe' ? 'active' : '' ?>"><a href="<?php echo base_url() ?>/lienhe.php">Liên hệ</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php include("header-tablet.php"); ?>
	