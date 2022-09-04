<?php
session_start();
$open='ql-tintuc';
include("../../../../library/function.php");
include("../../../../connect.php");

if (isset($_POST['btn-submit'])) {
	$id_dmtt=$_POST['id_dmtt'];
	$tieude=$_POST['tieude'];
	$tomtat=$_POST['tomtat'];
	$noidung=$_POST['noidung'];
	$trangthai=$_POST['trangthai'];
	$hinhanh=$_FILES['hinhanh'];
	$time=time();

	if ($id_dmtt=='' || $tieude=='' || $tomtat=='' || $noidung=='' || $hinhanh['name']=='') {
		echo "<script>alert('Lỗi ! Bạn chưa nhập đủ thông tin'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sqlCheck="SELECT * FROM tintuc WHERE tieude='$tieude'";
	$rlCheck=mysqli_query($conn,$sqlCheck);
	$Check=mysqli_num_rows($rlCheck);
	if ($Check > 0) {
		echo "<script>alert('Lỗi ! Tiêu đề bài viết đã tồn tại'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$hinhanh_ten=$hinhanh['name'];
	move_uploaded_file($hinhanh['tmp_name'], '../../../../img/news/'.$time.$hinhanh_ten);

	$sqlInsert = "INSERT INTO tintuc(id_dmtt,tieude,hinhanh,tomtat,noidung,trangthai_tt,id_ad) VALUES('$id_dmtt','$tieude','$time$hinhanh_ten','$tomtat','$noidung','$trangthai','".$_SESSION['admin']."')";
	$rlInsert = mysqli_query($conn,$sqlInsert);
	$idInsert = mysqli_insert_id($conn);
	if ($idInsert > 0) {
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
			<li><a href="index.php">Quản lý tin tức</a></li>
			<li><a href="index.php">Tin tức</a></li>
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
						<option value="<?php echo $id_dmtt; ?>"><?php echo $ten_dmtt; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label>Tiêu đề:</label>
					<input type="text" name="tieude" placeholder="Nhập tiêu đề...">
				</div>
				<div class="form-group">
					<label>Hình ảnh đại diện:</label>
					<input type="file" name="hinhanh">
				</div>
				<div class="form-group">
					<label>Tóm tắt:</label>
					<textarea name="tomtat"></textarea>
				</div>
				<div class="form-group">
					<label>Nội dung:</label>
					<textarea name="noidung" class="ckeditor"></textarea>
				</div>
				<div class="form-group">
					<label>Trạng thái:</label>
					<select name="trangthai">
						<option value="0">--- Hiện thi ---</option>
						<option value="1">--- Ẩn ---</option>
					</select>
				</div>
				<div class="form-group">
					<button type="submit" name="btn-submit" class="btn-primary"><i class="fa fa-plus"></i>Thêm mới</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include("../../../layout/footer.php") ?>