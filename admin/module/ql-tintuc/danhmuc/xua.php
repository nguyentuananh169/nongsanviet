<?php
session_start();
include("../../../../library/function.php");
include("../../../../connect.php");
$open='ql-tintuc';
$id_dmtt=$_GET['id_dmtt'];
$sql="SELECT * FROM danhmuc_tintuc WHERE id_dmtt='$id_dmtt'";
$rl=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($rl);
if (isset($_POST['btn-submit'])) {
	$ten_dmtt=$_POST['ten_dmtt'];
	$trangthai=$_POST['trangthai'];
	if ($ten_dmtt=='' || $trangthai=='') {
		echo "<script>alert('Lỗi! Bạn chưa nhập đủ thông tin'),location.href='javascript:history.go(-1)'</script>";
		die();
	}
	$sqlCheck="SELECT * FROM danhmuc_tintuc WHERE ten_dmtt='$ten_dmtt' AND id_dmtt!=$id_dmtt";
	$rlCheck=mysqli_query($conn,$sqlCheck);
	$check=mysqli_num_rows($rlCheck);
	if ($check>0) {
		echo "<script>alert('Lỗi ! Tên danh mục đã tồn tại'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sqlUpdate="UPDATE danhmuc_tintuc SET ten_dmtt='$ten_dmtt',trangthai='$trangthai' WHERE id_dmtt='$id_dmtt'";
	$rlUpdate=mysqli_query($conn,$sqlUpdate);
	$_SESSION['success']="Lưu thành công";
	header("location:index.php");
	die();
}
?>
<?php include("../../../layout/header.php"); ?>
<div class="content-right">
	<div class="path">
		<ul>
			<li><a href="<?php echo base_url_admin() ?>">Trang chủ</a></li>
			<li><a href="index.php">Quản lý tin tức</a></li>
			<li><a href="index.php">Danh mục tin tức</a></li>
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
			<form action="" method="post">
				<div class="form-group">
					<label>Nhập tên danh mục:</label>
					<input type="text" name="ten_dmtt" placeholder="Nhập tên danh mục..." value="<?php echo $row['ten_dmtt']; ?>">
				</div>
				<div class="form-group">
					<label>Trạng thái:</label>
					<select name="trangthai">
						<option value="0" <?php echo isset($row['trangthai']) && $row['trangthai'] == 0 ? 'selected' : '' ?>>--- Hiện thị ---</option>
						<option value="1" <?php echo isset($row['trangthai']) && $row['trangthai'] == 1 ? 'selected' : '' ?>>--- Ẩn ---</option>
					</select>
				</div>
				<div class="form-group">
					<button type="submit" name="btn-submit" class="btn btn-primary"><i class="fa fa-edit"></i>Lưu lại</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include("../../../layout/footer.php"); ?>