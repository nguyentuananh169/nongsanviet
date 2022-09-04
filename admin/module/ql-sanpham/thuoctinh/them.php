<?php
session_start();
$open='ql-sanpham';
include("../../../../library/function.php");
include("../../../../connect.php");
if (isset($_POST['btn-submit'])) {
	$ten_tt=$_POST['ten_tt'];

	if ($ten_tt=='') {
		echo "<script>alert('Lỗi! Bạn chưa nhập đủ thông tin'),location.href='javascript:history.go(-1)'</script>";
		die();
	}
	$sqlCheck="SELECT * FROM thuoctinh WHERE ten_tt='$ten_tt'";
	$rlCheck=mysqli_query($conn,$sqlCheck);
	$check=mysqli_num_rows($rlCheck);
	if ($check>0) {
		echo "<script>alert('Lỗi! Tên danh mục đã tồn tại'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sql="INSERT INTO thuoctinh(ten_tt) VALUES('$ten_tt')";
	$rl=mysqli_query($conn,$sql);
	$id_insert=mysqli_insert_id($conn);
	if ($id_insert==0) {
		$_SESSION['error']='Thêm mới thất bại !';
	    header("location:them.php");
	    die();
	}
	if ($id_insert>0) {
		$_SESSION['success']='Thêm mới thành công !';
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
			<li><a href="index.php">Quản lý sản phẩm</a></li>
			<li><a href="index.php">Danh sách thuộc tính</a></li>
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
			<form action="" method="post">
				<div class="form-group">
					<label>Nhập tên thuộc tính:</label>
					<input type="text" name="ten_tt" placeholder="Nhập tên thuộc tính...">
				</div>
				<div class="form-group">
					<button type="submit" name="btn-submit" class="btn btn-primary"><i class="fa fa-plus"></i>Thêm mới</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include("../../../layout/footer.php") ?>