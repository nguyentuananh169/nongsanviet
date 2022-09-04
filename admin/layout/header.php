<?php 
session_start();
if (!isset($_SESSION['admin'])) {
	header("location:".base_url_admin()."/dangnhap.php");
	die();
}
include("../../connect.php");
$sqlOrder = "SELECT * FROM donhang WHERE trangthai = 0";
$rlOrder = mysqli_query($conn,$sqlOrder);
$order = mysqli_num_rows($rlOrder);

$sqlContact = "SELECT * FROM lienhe WHERE trangthai = 0";
$rlContact = mysqli_query($conn,$sqlContact);
$contact = mysqli_num_rows($rlContact);

$sqlCmt = "SELECT * FROM binhluan_sp WHERE parent_id = 0 AND trangthai = 0";
$rlCmt = mysqli_query($conn,$sqlCmt);
$cmt = mysqli_num_rows($rlCmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=w">
	<title>Trang quản lý Website</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url_admin() ?>/style/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/style/css/base.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.17.2/ckeditor.js"></script>
</head>
<body>
	<div class="wrapper">
		<div class="container-left">
			<div class="header-left">
				<h4>ADMIN</h4>
			</div>
			<div class="content-left">
				<div class="nav-menu-item">
					<ul>
						<li class="<?php echo isset($open) && $open == 'trangchu' ? 'active' : '' ?>">
							<a href="<?php echo base_url_admin() ?>/"><i class="fa fa-home"></i>Trang chủ</a>
						</li>
						<li class="dropdown-menu <?php echo isset($open) && $open == 'ql-sanpham' ? 'active' : '' ?>">
							<a href="#"><i class="fa fa-database"></i>Quản lý sản phẩm</a>
							<ul class="menu-con">
								<li><a href="<?php echo base_url_admin() ?>/module/ql-sanpham/danhmuc">Danh mục sản phẩm</a></li>
								<li><a href="<?php echo base_url_admin() ?>/module/ql-sanpham/sanpham">Sản phẩm</a></li>
								<li><a href="<?php echo base_url_admin() ?>/module/ql-sanpham/thuoctinh">Thuộc tính sản phẩm</a></li>
							</ul>
						</li>
						<li class="<?php echo isset($open) && $open == 'ql-donhang' ? 'active' : '' ?>">
							<a href="<?php echo base_url_admin() ?>/module/ql-donhang">
								<i class="fa fa-shopping-bag"></i>Quản lý đơn hàng 
								<span class="order">(<?php echo number_format($order); ?>)</span>
							</a>
						</li>
						<li class="dropdown-menu <?php echo isset($open) && $open == 'ql-nguoidung' ? 'active' : '' ?>">
							<a href="#"><i class="fa fa-user-circle-o"></i>Quản lý người dùng</a>
							<ul class="menu-con">
								<li><a href="<?php echo base_url_admin() ?>/module/ql-nguoidung/admin">Admin</a></li>
								<li><a href="<?php echo base_url_admin() ?>/module/ql-nguoidung/thanhvien">Thành viên</a></li>
							</ul>
						</li>
						<li class="dropdown-menu <?php echo isset($open) && $open == 'ql-tintuc' ? 'active' : '' ?>">
							<a href="#"><i class="fa fa-newspaper-o"></i>Quản lý tin tức</a>
							<ul class="menu-con">
								<li><a href="<?php echo base_url_admin() ?>/module/ql-tintuc/danhmuc/">Danh mục tin tức</a></li>
								<li><a href="<?php echo base_url_admin() ?>/module/ql-tintuc/tintuc/">Tin tức</a></li>
							</ul>
						</li>
						<li class="<?php echo isset($open) && $open == 'ql-lienhe' ? 'active' : '' ?>">
							<a href="<?php echo base_url_admin() ?>/module/ql-lienhe">
								<i class="fa fa-compress"></i>Quản lý liên hệ
								<span class="order">(<?php echo number_format($contact); ?>)</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!--  -->
		<div class="container-right">
			<div class="header-right">
				<div class="menu-left">
					<div class="bars">
						<i class="fa fa-bars"></i>
					</div>
					<div class="nav-menu-left">
						<ul>
							<li><a href="<?php echo base_url_admin() ?>/">Trang chủ</a></li>
							<li><a href="<?php echo base_url_admin() ?>/thongtin.php">Tài khoản</a></li>
							<li><a href="">Cài đặt</a></li>
						</ul>
					</div>
				</div>
				<div class="menu-right">
					<div class="nav-menu-right">
						<ul>
							<li>
								<label for="">
									<i class="fa fa-bell-o"></i>
									<span class="bell">99</span>
								</label>
							</li>
							<li>
								<label for="">
									<i class="fa fa-envelope-o"></i>
									<span class="envelope">99</span>
								</label>
							</li>
						</ul>
					</div>
					<div class="avt-user">
						<label for="click-avt-user">
							<img src="<?php echo base_url() ?>/img/icon/avatar-user-ad.png" width="100%" height="100%">
						</label>
						<input type="checkbox" id="click-avt-user" hidden>
						<div class="dropdown-menu-user">
							<h3>Tài khoản</h3>
							<ul>
								<li>
									<a href="<?php echo base_url_admin() ?>/thongtin.php"><i class="fa fa-user-circle-o"></i>Tài khoản</a>
								</li>
								<li>
									<a href=""><i class="fa fa-envelope-o"></i>Tin nhắn</a>
								</li>
								<li>
									<a href=""><i class="fa fa-bell-o"></i>Thông báo</a>
								</li>
							</ul>
							<h3>Cài đặt</h3>
							<ul>
								<li>
									<a href=""><i class="fa fa-cog"></i>Cài đặt</a>
								</li>
								<li class="b-top">
									<a href="<?php echo base_url_admin() ?>/dangxuat.php"><i class="fa fa-sign-out"></i>Đăng xuất</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			
		