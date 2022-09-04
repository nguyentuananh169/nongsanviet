<?php
session_start();
if (isset($_SESSION['user'])) {
	header("location:index.php");
	die();
}
include("connect.php");
include("library/function.php");
if (isset($_POST['btn-submit'])) {
	$ten=$_POST['ten'];
	$email=$_POST['email'];
	$matkhau=$_POST['matkhau'];
	$re_matkhau=$_POST['re_matkhau'];
	$sdt=$_POST['sdt'];
	$diachi=$_POST['diachi'];

	if ($ten=='' || $email=='' || $matkhau=='' || $re_matkhau=='' || $sdt=='' || $diachi=='') {
		echo "<script>alert('Lỗi ! Bạn chưa nhập đủ thông tin !'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	if ($matkhau!=$re_matkhau) {
		echo "<script>alert('Lỗi ! Mật khẩu nhập lại không trùng khớp !'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sqlCheckEmail="SELECT * FROM thanhvien WHERE email_tv = '$email' ";
	$rlCheckEmail=mysqli_query($conn,$sqlCheckEmail);
	$CheckEmail=mysqli_num_rows($rlCheckEmail);
	if ($CheckEmail > 0) {
		echo "<script>alert('Lỗi ! Email đã tồn tại!'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sqlCheckSDT="SELECT * FROM thanhvien WHERE sdt_tv = '$sdt' ";
	$rlCheckSDT=mysqli_query($conn,$sqlCheckSDT);
	$CheckSDT=mysqli_num_rows($rlCheckSDT);
	if ($CheckSDT > 0) {
		echo "<script>alert('Lỗi ! Số điện thọai đã tồn tại!'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$matkhau=md5($matkhau);

	$sqlINSERT="INSERT INTO thanhvien(ten_tv,email_tv,matkhau_tv,sdt_tv,diachi_tv) VALUES('$ten','$email','$matkhau','$sdt','$diachi')";
	$rlINSERT=mysqli_query($conn,$sqlINSERT);

	$id_insert=mysqli_insert_id($conn);
	if ($id_insert>0) {
		$_SESSION['success']='Đăng ký thành công ! Mời bạn đăng nhập !';
		header("location:dangnhap.php");
		die();
	}else{
		$_SESSION['error']='Đăng ký thất bại';
		header("location:dangky.php");
		die();
	}
}
?>
<?php include("layout/header.php") ?> 
<div class="container">
	<div class="wide">
		<form action="" method="post">
		    <div class="form-register">
			    <div class="register">
				    <h3>Đăng ký tài khoản</h3>
				    
				    <?php if (isset($_SESSION['success'])) :?>
				    	<p class="success"><?php echo $_SESSION['success']; ?></p>
				    	<?php unset($_SESSION['success']); ?>
				    <?php endif; ?>

				    <?php if (isset($_SESSION['error'])) :?>
				    	<p class="error"><?php echo $_SESSION['error']; ?></p>
				    	<?php unset($_SESSION['error']); ?>
				    <?php endif; ?>

				    <div class="group-input">
					    <label>Họ tên:</label>
					    <input type="text" name="ten" placeholder="Họ tên *">
				    </div>
				    <div class="group-input">
					    <label>Email:</label>
					    <input type="email" name="email" placeholder="Email *">
				    </div>
				    <div class="group-input">
					    <label>Mật khẩu:</label>
					    <input type="text" name="matkhau" placeholder="Mật khẩu *">
				    </div>
				    <div class="group-input">
					    <label>Nhập lại mật khẩu:</label>
					    <input type="text" name="re_matkhau" placeholder="Nhập lại mật khẩu *">
			     	</div>
				    <div class="group-input">
					    <label>Số điện thoại:</label>
					    <input type="number" name="sdt" placeholder="Số điện thoại *">
				    </div>
				    <div class="group-input">
					    <label>Địa chỉ:</label>
					    <input type="text" name="diachi" maxlength="50" placeholder="Địa chỉ *">
				    </div>
				    <div class="group-button">
					    <button type="submit" name="btn-submit">ĐĂNG KÝ</button>
				    </div>
			    </div>
		    </div>
		</form>
	</div>
</div>
<?php include("layout/footer.php") ?>