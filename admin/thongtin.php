<?php
session_start();
include("../connect.php");
include("../library/function.php");

$sql="SELECT * FROM admin WHERE id_ad=".$_SESSION['admin'];
$rl=mysqli_query($conn,$sql);
$admin=mysqli_fetch_assoc($rl);

if (isset($_POST['btn-submit'])) {
	$ten=$_POST['ten'];
	$email=$_POST['email'];
	$sdt=$_POST['sdt'];
	$diachi=$_POST['diachi'];
	$matkhau=$_POST['matkhau'];
	$matkhau2=$_POST['matkhau2'];
	$re_matkhau2=$_POST['re_matkhau2'];

	if ($ten=='' || $email=='' || $sdt=='' || $diachi =='') {
		echo "<script>alert('Lỗi! Bạn chưa nhập đủ thông tin'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sqlCheckEmail="SELECT * FROM admin WHERE email_ad='$email' AND id_ad != ".$_SESSION['admin'];
	$rlCheckEmail=mysqli_query($conn,$sqlCheckEmail);
	$checkEmail=mysqli_num_rows($rlCheckEmail);

	if ($checkEmail > 0) {
		echo "<script>alert('Lỗi! Email đã tồn tại'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sqlCheckSDT="SELECT * FROM admin WHERE sdt_ad='$sdt' AND id_ad != ".$_SESSION['admin'];
	$rlCheckSDT=mysqli_query($conn,$sqlCheckSDT);
	$checkSDT=mysqli_num_rows($rlCheckSDT);

	if ($checkSDT > 0) {
		echo "<script>alert('Lỗi! Số điện thoại đã tồn tại'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	if ($matkhau=="" || $matkhau2=="" || $re_matkhau2=="") {

		$sql1="UPDATE admin SET ten_ad='$ten', email_ad='$email', sdt_ad='$sdt', diachi_ad='$diachi' WHERE id_ad=".$_SESSION['admin'];
		$sql1=mysqli_query($conn,$sql1);

		echo "<script>alert('Cập nhật thành công !'),location.href='thongtin.php'</script>";
		die();

	}else{
		$matkhau=md5($matkhau);
		$sqlCheckPass="SELECT * FROM admin WHERE matkhau_ad='$matkhau' AND id_ad=".$_SESSION['admin'];
		$rlCheckPass=mysqli_query($conn,$sqlCheckPass);
		$checkPass=mysqli_num_rows($rlCheckPass);

		if ($checkPass > 0) {
			if ($matkhau2==$re_matkhau2) {
				$matkhau2=md5($matkhau2);

				$sql2="UPDATE admin SET ten_ad='$ten', email_ad='$email', sdt_ad='$sdt', diachi_ad='$diachi', matkhau_ad='$matkhau2' WHERE id_ad=".$_SESSION['admin'];
				$sql2=mysqli_query($conn,$sql2);

				echo "<script>alert('Cập nhật thành công !'),location.href='thongtin.php'</script>";
				die();

			}else{
				echo "<script>alert('Lỗi! Mật khẩu mới nhập lại không trùng khớp'),location.href='javascript:history.go(-1)'</script>";
			die();
			}
		}else{
			echo "<script>alert('Lỗi! Mật khẩu cũ bạn nhập không đúng'),location.href='javascript:history.go(-1)'</script>";
			die();
		}
	}
}
?>
<?php include("layout/header.php") ?>
<div class="content-right">
	<div class="path">
		<ul>
			<li><a href="<?php echo base_url_admin() ?>">Trang chủ</a></li>
			<li><a href="">Thông tin tài khoản</a></li>
		</ul>
	</div>
	<div class="main-content">
		<div class="content">
			<h3 style="text-align: center;margin-bottom: 20px;">Thông tin tài khoản</h3>
			<i style="display: block;text-align: center;margin-bottom: 20px;">Lưu ý: Những trường có dấu <b class="note">(*)</b> được phép thay đổi nhưng không được để trống !</i>
			<form action="" method="post">
				<div class="form-group">
					<label>ID Admin:</label>
					<input type="number" name="id" readonly placeholder="ID Admin *" value="<?php echo $admin['id_ad']; ?>">
				</div>
				<div class="form-group">
					<label>Họ và tên:<b class="note">*</b></label>
					<input type="text" name="ten" placeholder="Họ và tên *" value="<?php echo $admin['ten_ad']; ?>">
				</div>
				<div class="form-group">
					<label>Email:<b class="note">*</b></label>
					<input type="email" name="email" placeholder="Email *" value="<?php echo $admin['email_ad']; ?>">
				</div>
				<div class="form-group">
					<label>Số điện thoại:<b class="note">*</b></label>
					<input type="number" name="sdt" placeholder="Số điện thoại *" value="<?php echo $admin['sdt_ad']; ?>">
				</div>
				<div class="form-group">
					<label>Địa chỉ:<b class="note">*</b></label>
					<input type="text" name="diachi" placeholder="Địa chỉ *" value="<?php echo $admin['diachi_ad']; ?>">
				</div>
				<div class="form-group">
					<label>Ngày tạo:</label>
					<input type="text" name="ngaytao" readonly placeholder="Ngày tạo *" value="<?php echo $admin['ngaytao_ad']; ?>">
				</div>
				<div class="form-group">
					<label>Ngày cập nhật cuối:</label>
					<input type="text" name="ngayupdate" readonly placeholder="Ngày cập nhật cuối *" value="<?php echo $admin['ngayupdate_ad']; ?>">
				</div>
				<div class="form-group">
					<label></label>
					<span style="display: inline-block;width: 85%;height: 40px;color: #f60;line-height: 40px;">
						Để trống mật khẩu nếu không muốn thay đổi mật khẩu
					</span>
				</div>
				<div class="form-group">
					<label>Mật khẩu cũ:</label>
					<input type="text" name="matkhau" placeholder="Nhập mật khẩu cũ">
				</div>
				<div class="form-group">
					<label>Mật khẩu mới:</label>
					<input type="text" name="matkhau2" placeholder="Nhập mật khẩu mới">
				</div>
				<div class="form-group">
					<label>Nhập lại mật khẩu mới:</label>
					<input type="text" name="re_matkhau2" placeholder="Nhập lại mật khẩu mới" >
				</div>
				<div class="form-group">
					<button type="submit" name="btn-submit" class="btn btn-primary">
					<i class="fa fa-edit"></i>Cập nhật
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include("layout/footer.php") ?>