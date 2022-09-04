<?php
session_start(); 
include("../library/function.php");
include("../connect.php");
$open1="thongtin";
if (!isset($_SESSION['user'])) {
	header('location: '.base_url());
	die();
}
$sql="SELECT * FROM thanhvien WHERE id_tv=".$_SESSION['user'];
$rl=mysqli_query($conn, $sql);
$user=mysqli_fetch_assoc($rl);

if (isset($_POST['btn-submit'])) {
	$ten=$_POST['ten'];
	$email=$_POST['email'];
	$sdt=$_POST['sdt'];
	$diachi=$_POST['diachi'];
	$matkhau=$_POST['matkhau'];
	$matkhau_1=$_POST['matkhau_1'];
	$re_matkhau=$_POST['re_matkhau'];

	if ($ten=='' || $email=='' || $sdt=='' || $diachi=='') {
		echo "<script>alert('Lỗi ! Bạn chưa nhập đủ thông tin !'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sqlCheckEmail="SELECT * FROM thanhvien WHERE email_tv='$email' AND id_tv!=".$user['id_tv'];
	$rlCheckEmail=mysqli_query($conn, $sqlCheckEmail);
	$CheckEmail=mysqli_num_rows($rlCheckEmail);
	if ($CheckEmail > 0) {
		echo "<script>alert('Lỗi ! Email bạn nhập đã tồn tại !'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sqlCheckSDT="SELECT * FROM thanhvien WHERE sdt_tv='$sdt' AND id_tv!=".$user['id_tv'];
	$rlCheckSDT=mysqli_query($conn, $sqlCheckSDT);
	$CheckSDT=mysqli_num_rows($rlCheckSDT);
	if ($CheckSDT > 0) {
		echo "<script>alert('Lỗi ! SĐT bạn nhập đã tồn tại !'),location.href='javascript:history.go(-1)'</script>";
		die();
	}
	if ($matkhau=='' || $matkhau_1=='' || $re_matkhau=='') {
		$sql1="UPDATE thanhvien SET ten_tv='$ten',email_tv='$email',sdt_tv='$sdt',diachi_tv='$diachi' WHERE id_tv=".$user['id_tv'];
		$rl1=mysqli_query($conn, $sql1);
		echo "<script>alert('Cập nhật thành công !'),location.href='index.php'</script>";
		die();
	}else{
		$matkhau=$_POST['matkhau'];
		$matkhau_1=$_POST['matkhau_1'];
		$re_matkhau=$_POST['re_matkhau'];

		$matkhau=md5($matkhau);

		$sqlCheckPass="SELECT * FROM thanhvien WHERE matkhau_tv='$matkhau' AND id_tv=".$user['id_tv'];
		$rlCheckPass=mysqli_query($conn, $sqlCheckPass);
		$CheckPass=mysqli_num_rows($rlCheckPass);
		if ($CheckPass > 0) {

			if ($matkhau_1 == $re_matkhau) {

				$matkhau_1=md5($matkhau_1);
				$sql2="UPDATE thanhvien SET ten_tv='$ten',email_tv='$email',sdt_tv='$sdt',diachi_tv='$diachi',matkhau_tv='$matkhau_1' WHERE id_tv=".$user['id_tv'];
				$rl2=mysqli_query($conn, $sql2);
				echo "<script>alert('Cập nhật thành công !'),location.href='index.php'</script>";
				die();

			}else{
				echo "<script>alert('Lỗi ! Mật khẩu mới nhập lại không trùng khớp !'),location.href='javascript:history.go(-1)'</script>";
				die();
			}

		}else{
			echo "<script>alert('Lỗi ! Mật khẩu cũ nhập lại không trùng khớp !'),location.href='javascript:history.go(-1)'</script>";
			die();
		die();
		}
	}
}
?>
<?php include("../layout/header.php") ?>
<div class="container">
	<div class="wide">
		<div class="path">
			<ul>
				<li><a href="<?php echo base_url() ?>">Trang chủ</a></li>
				<li><a href="">Bảng điều khiển</a></li>
				<li><a href="">Thông tin của bạn</a></li>
			</ul>
		</div>
	</div>
	<div class="wide info-user">
		<?php include("dashboard.php") ?>
		<div class="dashboard-main">
			<h3>Đơn hàng của bạn</h3>
			<form action="" method="post">
				<div class="dashboard-main-content">
					<div class="form-gr">
						<label>ID Thành viên <b>*</b> :</label>
						<input type="text" readonly placeholder="ID của bạn *" value="<?php echo $user['id_tv']; ?>">
					</div>
					<div class="form-gr">
						<label>Họ và tên <b>*</b> :</label>
						<input type="text" name="ten" placeholder="Họ và tên *" value="<?php echo $user['ten_tv']; ?>">
					</div>
					<div class="form-gr">
						<label>Email <b>*</b> :</label>
						<input type="email" name="email" placeholder="Email *" value="<?php echo $user['email_tv']; ?>">
					</div>
					<div class="form-gr">
						<label>Số điện thoại <b>*</b> :</label>
						<input type="number" name="sdt" placeholder="Số điện thoại *" value="<?php echo $user['sdt_tv']; ?>">
					</div>
					<div class="form-gr">
						<label>Địa chỉ <b>*</b> :</label>
						<input type="text" name="diachi" placeholder="Địa chỉ *" value="<?php echo $user['diachi_tv']; ?>">
					</div>
					<div class="form-gr">
						<label class="h0"></label>
						<span>Để trống nếu không muốn thay đổi mật khẩu.</span>
					</div>
					<div class="form-gr">
						<label>Mật khẩu cũ:</label>
						<input type="text" name="matkhau" placeholder="Mật khẩu cũ">
					</div>
					<div class="form-gr">
						<label>Mật khẩu mới:</label>
						<input type="text" name="matkhau_1" placeholder="Mật khẩu mới">
					</div>
					<div class="form-gr">
						<label>Nhập lại mật khẩu mới:</label>
						<input type="text" name="re_matkhau" placeholder="Nhập lại mật khẩu mới">
					</div>
					<div class="form-gr">
						<label></label>
						<button type="submit" name="btn-submit">Xác nhận</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include("../layout/footer.php") ?>