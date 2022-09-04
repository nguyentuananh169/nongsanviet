<?php
session_start(); 
include("library/function.php");
include("connect.php");
$open="lienhe";
if (isset($_POST['btn-submit'])) {
	$ten=$_POST['ten'];
	$email=$_POST['email'];
	$sdt=$_POST['sdt'];
	$gt=$_POST['gt'];
	$diachi=$_POST['diachi'];
	$noidung=$_POST['noidung'];

	if ($ten == "" || $email == "" || $sdt == "" || $gt == "" || $diachi == "" || $noidung == "") {
		echo "<script>alert('Lỗi ! Bạn chưa nhập đủ thông tin !'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sql="INSERT INTO lienhe(ten,email,sdt,gioitinh,noidung,diachi) VALUES('$ten','$email','$sdt','$gt','$noidung','$diachi')";
	$rl=mysqli_query($conn,$sql);

	$idInsert=mysqli_insert_id($conn);

	if ($idInsert > 0) {
		echo "<script>alert('Gửi nội dung liên hệ thành công !'),location.href='lienhe.php'</script>";
	}else{
		echo "<script>alert('Gửi nội dung liên hệ thất bại !'),location.href='javascript:history.go(-1)'</script>";
	}

}
?>
<?php include("layout/header.php") ?> 
<div class="container">
	<div class="wide">
		<div class="path">
			<ul>
				<li><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Trang chủ</a></li>
				<li><a href="">Liên hệ</a></li>
			</ul>
		</div>
		<div class="contact">
			<form action="" method="post">
				<div class="form-contact">
					<label>Họ và tên:</label>
					<input type="text" name="ten" placeholder="Nhập họ tên của bạn...">
				</div>
				<div class="form-contact">
					<label>Email:</label>
					<input type="email" name="email" placeholder="Nhập email của bạn...">
				</div>
				<div class="form-contact">
					<label>Số điện thọai:</label>
					<input type="number" name="sdt" placeholder="Nhập SĐT của bạn...">
				</div>
				<div class="form-contact">
					<label>Giới tinh:</label>
					<select name="gt">
						<option value=""> Vui lòng chọn </option>
						<option value="0"> Nam </option>
						<option value="1"> Nữ </option>
					</select>
				</div>
				<div class="form-contact">
					<label>Đia chi:</label>
					<input type="text" name="diachi" placeholder="Nhập đia chi của bạn...">
				</div>
				<div class="form-contact">
					<label>Nội dung:</label>
					<textarea name="noidung"></textarea>
				</div>
				<div class="form-contact">
					<label></label>
					<button type="submit" name="btn-submit">Gửi đi</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include("layout/footer.php") ?>