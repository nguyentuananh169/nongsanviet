<?php
session_start();
$open='ql-nguoidung';
include("../../../../library/function.php");
include("../../../../connect.php");
if (isset($_POST['btn-submit'])) {
	$ten=$_POST['ten'];
	$email=$_POST['email'];
	$matkhau=$_POST['matkhau'];
	$re_matkhau=$_POST['re_matkhau'];
	$sdt=$_POST['sdt'];
	$diachi=$_POST['diachi'];

	if ($ten=='' || $email=='' || $matkhau=='' || $re_matkhau=='' || $sdt=='' || $diachi=='') {
		echo "<script>alert('Lỗi ! Bạn chưa nhập đủ thông tin'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sqlCheckEmail="SELECT * FROM thanhvien WHERE email_tv='$email'";
	$rlCheckEmail=mysqli_query($conn,$sqlCheckEmail);
	$CheckEmail=mysqli_num_rows($rlCheckEmail);
	if ($CheckEmail > 0) {
		echo "<script>alert('Lỗi ! Email đã tồn tại'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	if ($matkhau != $re_matkhau) {
		echo "<script>alert('Lỗi ! Mật khẩu nhập lại không trùng khớp'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sqlCheckSDT="SELECT * FROM thanhvien WHERE sdt_tv='$sdt'";
	$rlCheckSDT=mysqli_query($conn,$sqlCheckSDT);
	$CheckSDT=mysqli_num_rows($rlCheckSDT);
	if ($CheckSDT > 0) {
		echo "<script>alert('Lỗi ! Số điện thoại đã tồn tại'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$matkhau=md5($matkhau);

	$sql="INSERT INTO thanhvien(ten_tv,email_tv,sdt_tv,matkhau_tv,diachi_tv) VALUES('$ten','$email','$sdt','$matkhau','$diachi')";
	$rlCheckEmail=mysqli_query($conn,$sql);

	$id_insert=mysqli_insert_id($conn);

	if ($id_insert > 0) {
		$_SESSION['success']='Thêm mới thành công !';
		header("location:them.php");
		die();
	}else{
		$_SESSION['error']='Thêm mới thất bại !';
		header("location:them.php");
		die();
	}
}
?>
<?php include("../../../layout/header.php") ?>
<div class="content-right">
	<div class="path">
		<ul>
			<li><a href="<?php echo base_url_admin() ?>">Trang chủ</a></li>
			<li><a href="index.php">Quản lý thành viên</a></li>
			<li><a href="index.php">Thành viên</a></li>
			<li><a href="">Thêm mới</a></li>
		</ul>
	</div>
	<div class="main-content">
		<div class="add-item">
			<a class="btn-primary" href="index.php"><i class="fa fa-undo"></i>Quay lại</a>
		</div>
		<?php if (isset($_SESSION['error'])) : ?>
    	<div class="session-error">
    		<span>
    			<?php 
    			echo $_SESSION['error'];
    			unset($_SESSION['error']);
    			?>
    		</span>
    	</div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])) : ?>
    	<div class="session-success">
    		<span>
    			<?php 
    			echo $_SESSION['success'];
    			unset($_SESSION['success']);
    			?>
    		</span>
    	</div>
    	<?php endif; ?>
		<div class="content">
			<form action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label>Họ tên:</label>
					<input type="text" name="ten" placeholder="Nhập họ tên...">
				</div>
				<div class="form-group">
					<label>Email:</label>
					<input type="email" name="email" placeholder="Nhập email...">
				</div>
				<div class="form-group">
					<label>Mật khẩu:</label>
					<input type="text" name="matkhau" placeholder="Nhập mật khẩu...">
				</div>
				<div class="form-group">
					<label>Nhập lại mật khẩu:</label>
					<input type="text" name="re_matkhau" placeholder="Nhập lại mật khẩu...">
				</div>
				<div class="form-group">
					<label>Số điện thoại:</label>
					<input type="number" name="sdt" placeholder="Nhập SĐT...">
				</div>
				<div class="form-group">
					<label>Địa chỉ:</label>
					<input type="text" name="diachi" placeholder="Nhập địa chỉ">
				</div>
				<div class="form-group">
					<button type="submit" name="btn-submit" class="btn btn-primary"><i class="fa fa-plus"></i>Thêm mới</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include("../../../layout/footer.php") ?>