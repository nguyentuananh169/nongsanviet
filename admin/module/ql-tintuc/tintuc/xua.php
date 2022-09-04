<?php
session_start();
$open='ql-tintuc';
$id_tt=$_GET['id_tt'];
include("../../../../library/function.php");
include("../../../../connect.php");
$sqlTT="SELECT * FROM tintuc WHERE id_tt='$id_tt'";
$rlTT=mysqli_query($conn,$sqlTT);
$tintuc=mysqli_fetch_assoc($rlTT);

if (isset($_POST['btn-submit'])) {
	$id_dmtt=$_POST['id_dmtt'];
	$tieude=$_POST['tieude'];
	$tomtat=$_POST['tomtat'];
	$noidung=$_POST['noidung'];
	$trangthai_tt=$_POST['trangthai'];
	$hinhanh=$_FILES['hinhanh'];
	$time=time();

	if ($id_dmtt=='' || $tieude=='' || $tomtat=='' || $noidung=='') {
		echo "<script>alert('Lỗi ! Bạn chưa nhập đủ thông tin'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sqlCheck="SELECT * FROM tintuc WHERE tieude='$tieude' AND id_tt!='$id_tt'";
	$rlCheck=mysqli_query($conn,$sqlCheck);
	$Check=mysqli_num_rows($rlCheck);
	if ($Check > 0) {
		echo "<script>alert('Lỗi ! Tiêu đề bài viết đã tồn tại'),location.href='javascript:history.go(-1)'</script>";
		die();
	}
	// Nếu hinh ảnh tồn tại và không rỗng thì lưu vào thư mục
	if ($hinhanh['name']) {
		$hinhanh_ten=$hinhanh['name'];
		move_uploaded_file($hinhanh['tmp_name'], '../../../../img/news/'.$time.$hinhanh_ten);
	}
    // Nếu hình ảnh tồn tại và không rỗng thì cập nhật cả hình ảnh và ngược lại
	if ($hinhanh['name']) {
		$sqlUpdate="UPDATE tintuc SET id_dmtt='$id_dmtt',tieude='$tieude',tomtat='$tomtat',noidung='$noidung',trangthai_tt='$trangthai_tt',hinhanh='$time$hinhanh_ten' WHERE id_tt='$id_tt'";
		$rlUpdate=mysqli_query($conn,$sqlUpdate);
	}else{
		$sqlUpdate2="UPDATE tintuc SET id_dmtt='$id_dmtt',tieude='$tieude',tomtat='$tomtat',noidung='$noidung',trangthai_tt='$trangthai_tt' WHERE id_tt='$id_tt'";
		$rlUpdate2=mysqli_query($conn,$sqlUpdate2);
	}

	$_SESSION['success']='Xửa bài viết thành công !';
	header("location:index.php");
	die();
}
?>
<?php include("../../../layout/header.php") ?>
<div class="content-right">
	<div class="path">
		<ul>
			<li><a href="<?php echo base_url_admin() ?>">Trang chủ</a></li>
			<li><a href="index.php">Quản lý tin tức</a></li>
			<li><a href="index.php">Tin tức</a></li>
			<li><a href="">Xửa</a></li>
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
					<label>Chọn danh mục:</label>
					<select name="id_dmtt">
						<option value="">--- Chọn danh mục tin tức ---</option>
						<?php
						$sqlDMtt="SELECT * FROM danhmuc_tintuc";
						$rlDMtt=mysqli_query($conn,$sqlDMtt);
						while ($row=mysqli_fetch_assoc($rlDMtt)) {
							$id_dmtt=$row['id_dmtt'];
							$ten_dmtt=$row['ten_dmtt'];
						
						?>
						<option value="<?php echo $id_dmtt; ?>" <?php echo isset($tintuc['id_dmtt']) && $tintuc['id_dmtt'] == $id_dmtt ? 'selected' : '' ?>><?php echo $ten_dmtt; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label>Tiêu đề:</label>
					<input type="text" name="tieude" placeholder="Nhập tiêu đề..." value="<?php echo $tintuc['tieude']; ?>">
				</div>
				<div class="form-group">
					<label>Hình ảnh đại diện:</label>
					<input type="file" name="hinhanh">
				</div>
				<div class="form-group">
					<label></label>
					<div class="img-product">
						<img src="../../../../img/news/<?php echo $tintuc['hinhanh']; ?>" width="100px" height="100px">
					</div>
				</div>
				<div class="form-group">
					<label>Tóm tắt:</label>
					<textarea name="tomtat"><?php echo $tintuc['tomtat']; ?></textarea>
				</div>
				<div class="form-group">
					<label>Nội dung:</label>
					<textarea name="noidung" class="ckeditor"><?php echo $tintuc['noidung']; ?></textarea>
				</div>
				<div class="form-group">
					<label>Trạng thái:</label>
					<select name="trangthai">
						<option value="0" <?php echo isset($tintuc['trangthai_tt']) && $tintuc['trangthai_tt'] == 0 ? 'selected' : '' ?>>--- Hiện thi ---</option>
						<option value="1" <?php echo isset($tintuc['trangthai_tt']) && $tintuc['trangthai_tt'] == 1 ? 'selected' : '' ?>>--- Ẩn ---</option>
					</select>
				</div>
				<div class="form-group">
					<button type="submit" name="btn-submit" class="btn-primary"><i class="fa fa-edit"></i>Lưu lại</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include("../../../layout/footer.php") ?>