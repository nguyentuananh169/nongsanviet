<?php
session_start();
if (!isset($_SESSION['admin'])) {
	header("location:dangnhap.php");
	die();
}
include("../library/function.php");
include("../connect.php");
$open='trangchu';
?>
<?php include("layout/header.php") ?>
<div class="content-right">
	<div class="path">
		<ul>
			<li><a href="">Trang chủ</a></li>
			<li><a href="">Admin</a></li>
		</ul>
	</div>
	<div class="main-content">
		<h2>Chào mừng Admin !!!</h2>
	</div>
</div>
<?php include("layout/footer.php") ?>