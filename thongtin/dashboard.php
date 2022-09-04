<div class="dashboard">
	<h3><i class="fa fa-tachometer"></i>BẢNG ĐIỀU KHIỂN</h3>
	<ul>
		<li class="<?php echo isset($open1) && $open1=='thongtin' ? 'active' : '' ?>">
			<a href="index.php"><i class="fa fa-user-circle"></i>Thông tin của bạn</a>
		</li>
		<li class="<?php echo isset($open1) && $open1=='donhang' ? 'active' : '' ?>">
			<a href="donhang.php"><i class="fa fa-shopping-bag"></i>Đơn hàng của bạn</a>
		</li>
		<li class="<?php echo isset($open1) && $open1=='sp-yeuthich' ? 'active' : '' ?>">
			<a href="sp-yeuthich.php"><i class="fa fa-heart"></i>Sản phẩm yêu thích</a>
		</li>
		<li class="<?php echo isset($open1) && $open1=='binhluan' ? 'active' : '' ?>">
			<a href="ql-binhluan.php"><i class="fa fa-comments"></i>Quản lí bình luận</a>
		</li>
		<li style="border-top: 1px solid #6f3626;">
			<a href="../dangxuat.php"><i class="fa fa-sign-out"></i>Đăng xuất</a>
		</li>
	</ul>
</div>