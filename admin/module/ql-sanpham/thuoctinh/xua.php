<?php
session_start();
include("../../../../library/function.php");
include("../../../../connect.php");
$open='ql-sanpham';
$id_tt=$_GET['id_tt'];
$sql="SELECT * FROM thuoctinh WHERE id_tt='$id_tt'";
$rl=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($rl);
if (isset($_POST['btn-submit'])) {
	$ten_tt=$_POST['ten_tt'];
	if ($ten_tt=='') {
		echo "<script>alert('Lỗi! Bạn chưa nhập đủ thông tin'),location.href='javascript:history.go(-1)'</script>";
		die();
	}
	$sqlCheck="SELECT * FROM thuoctinh WHERE ten_tt='$ten_tt' AND id_tt!=$id_tt";
	$rlCheck=mysqli_query($conn,$sqlCheck);
	$check=mysqli_num_rows($rlCheck);
	if ($check>0) {
		echo "<script>alert('Lỗi ! Tên danh mục đã tồn tại'),location.href='javascript:history.go(-1)'</script>";
		die();
	}
	$sqlUpdate="UPDATE thuoctinh SET ten_tt='$ten_tt' WHERE id_tt='$id_tt'";
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
			<li><a href="index.php">Quản lý sản phẩm</a></li>
			<li><a href="index.php">Danh sách thuộc tính</a></li>
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
					<label>Nhập tên thuộc tính:</label>
					<input type="text" name="ten_tt" placeholder="Nhập tên thuộc tính..." value="<?php echo $row['ten_tt']; ?>">
				</div>
				<div class="form-group">
					<button type="submit" name="btn-submit" class="btn btn-primary"><i class="fa fa-edit"></i>Lưu lại</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include("../../../layout/footer.php"); ?>