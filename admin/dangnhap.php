<?php
session_start();
if (isset($_SESSION['admin'])) {
	header("location:index.php");
	die();
}
include("../library/function.php");
include("../connect.php");
if (isset($_POST['btn-submit'])) {
	$email=$_POST['email'];
	$matkhau=$_POST['matkhau'];

	if ($email=='' || $matkhau=='') {
		echo "<script>alert('Lỗi ! Bạn chưa nhập đủ thông tin !'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sqlCheckEmail="SELECT * FROM admin WHERE email_ad = '$email' ";
	$rlCheckEmail=mysqli_query($conn,$sqlCheckEmail);
	$CheckEmail=mysqli_num_rows($rlCheckEmail);
	if ($CheckEmail == 0) {
		echo "<script>alert('Lỗi ! Email không tồn tại!'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$matkhau=md5($matkhau);

	$sqlCheckPass="SELECT * FROM admin WHERE email_ad = '$email' AND matkhau_ad = '$matkhau' ";
	$rlCheckPass=mysqli_query($conn,$sqlCheckPass);
	$CheckPass=mysqli_num_rows($rlCheckPass);
	if ($CheckPass > 0) {
		$sqlData="SELECT * FROM admin WHERE email_ad = '$email' AND matkhau_ad = '$matkhau' ";
		$rlData=mysqli_query($conn,$sqlData);
		$data=mysqli_fetch_assoc($rlData);
		if ($data['trangthai_ad'] > 0){
			echo "<script>alert('Tài khoản của bạn đã bị chặn . Hãy liên hệ với người cung cấp tài khoản cho bạn  !'),location.href='javascript:history.go(-1)'</script>";
			die();
		}else{
			$_SESSION['admin'] = $data['id_ad'];
			header("location:index.php");
			die();
		}
	}else{
		echo "<script>alert('Lỗi ! Sai mật khẩu!'),location.href='javascript:history.go(-1)'</script>";
		die();
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Đăng nhập trang Admin</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url_admin() ?>/style/css/main.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>/style/css/base.css">
</head>
<body>
	<form action="" method="post">
		<div class="login-admin">
			<div class="form-login-admin">
				<h3>Trang đăng nhập</h3>
				<div class="validate-input">
					<input type="text" name="email" placeholder="Email">
				</div>
				<div class="validate-input">
					<input class="pass" type="password" name="matkhau" placeholder="Mật khẩu">
					<span><i class="fa fa-eye view-pass"></i></span>
				</div>
				<div class="tools">
					<div class="tool-1">
						<input type="checkbox" id="remember-me">
					    <label for="remember-me">Ghi nhớ</label>
					</div>
					<div class="tool-2">
						<a href="">Quên mật khẩu ?</a>
					</div>
				</div>
				<div class="btn-login">
					<button type="submit" name="btn-submit">Đăng nhập</button>
				</div>
			</div>
		</div>
	</form>
	<script>
		var viewPass = document.querySelector('.view-pass'),
		    inputPass= document.querySelector('.pass');
		viewPass.addEventListener('click',function(){
			if (viewPass.classList.contains('fa-eye')) {
				// 
				viewPass.classList.remove('fa-eye');
				viewPass.classList.add('fa-eye-slash');
				// 
				inputPass.removeAttribute('type');
				inputPass.setAttribute('type','text');
			}else{
				// 
				viewPass.classList.remove('fa-eye-slash');
				viewPass.classList.add('fa-eye');
				// 
				inputPass.removeAttribute('type');
				inputPass.setAttribute('type','password');
			}
		});
	</script>
</body>
</html>
