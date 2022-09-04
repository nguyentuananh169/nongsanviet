<?php
session_start();
if (isset($_SESSION['user'])) {
	header("location:index.php");
	die();
}
include("connect.php");
include("library/function.php");
if (isset($_POST['btn-submit'])) {
	$email=$_POST['email'];
	$matkhau=$_POST['matkhau'];

	if ($email=='' || $matkhau=='') {
		echo "<script>alert('Lỗi ! Bạn chưa nhập đủ thông tin !'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sqlCheckEmail="SELECT * FROM thanhvien WHERE email_tv = '$email' ";
	$rlCheckEmail=mysqli_query($conn,$sqlCheckEmail);
	$CheckEmail=mysqli_num_rows($rlCheckEmail);
	if ($CheckEmail == 0) {
		echo "<script>alert('Lỗi ! Email không tồn tại!'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$matkhau=md5($matkhau);

	$sqlCheckPass="SELECT * FROM thanhvien WHERE email_tv = '$email' AND matkhau_tv = '$matkhau' ";
	$rlCheckPass=mysqli_query($conn,$sqlCheckPass);
	$CheckPass=mysqli_num_rows($rlCheckPass);
	if ($CheckPass > 0) {
		$data=mysqli_fetch_assoc($rlCheckPass);
		if ($data['trangthai_tv'] > 0) {
			echo "<script>alert('Tài khoản của bạn đã bị chặn ! Vui lòng liên hệ Admin'),location.href='javascript:history.go(-1)'</script>";
			die();
		}else{
			$_SESSION['user']= $data['id_tv'];
			header("location:index.php");
			die();
		}
	}else{
		echo "<script>alert('Lỗi ! Sai mật khẩu!'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

}
?>
<?php include("layout/header.php") ?>
<div class="container">
	<div class="wide">
		<form action="" method="post">
		    <div class="form-login">
			    <div class="login">
				    <h3>Đăng nhập tài khoản</h3>
				    
				    <?php if (isset($_SESSION['success'])) :?>
				    	<p class="success"><?php echo $_SESSION['success']; ?></p>
				    	<?php unset($_SESSION['success']); ?>
				    <?php endif; ?>

				    <?php if (isset($_SESSION['error'])) :?>
				    	<p class="error"><?php echo $_SESSION['error']; ?></p>
				    	<?php unset($_SESSION['error']); ?>
				    <?php endif; ?>

				    <div class="group-input">
					    <label>Email:</label>
					    <input type="email" name="email" placeholder="Email *">
				    </div>
				    <div class="group-input">
					    <label>Mật khẩu:</label>
					    <input type="password" name="matkhau" placeholder="Mật khẩu *">
				    </div>
				    <div class="save-login">
					    <input type="checkbox" id="save">
					    <label for="save">Nhớ đăng nhập</label>
				    </div>
				    <div class="group-button">
					    <button type="submit" name="btn-submit">ĐĂNG NHẬP</button>
					    <a href="dangky.php">ĐĂNG KÝ</a>
				    </div>
				    <a class="forgot-password" href="">Quên mật khẩu ?</a>
			    </div>
		    </div>
		</form>
	</div>
</div>
<?php include("layout/footer.php") ?>