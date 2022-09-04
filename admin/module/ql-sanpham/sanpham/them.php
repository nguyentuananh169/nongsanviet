<?php
session_start();
$open='ql-sanpham';
include("../../../../library/function.php");
include("../../../../connect.php");
if (isset($_POST['btn-submit'])) {
	$id_dmsp=$_POST['id_dmsp'];
	$id_tt=$_POST['id_tt'];
	$ten_sp=$_POST['ten_sp'];
	$soluong=$_POST['soluong'];
	$gia_goc=$_POST['gia_goc'];
	$sale=$_POST['sale'];
	$hinhanh=$_FILES['hinhanh'];
	$noibat=$_POST['noibat'];
	$mota=$_POST['mota'];

	$gia=$gia_goc-(($gia_goc*$sale)/100);

	$time=time();

	if ($id_dmsp=='' || $id_tt=='' || $ten_sp=='' || $soluong=='' || $gia_goc=='' || $hinhanh['name']=='') {
		echo "<script>alert('Lỗi ! Bạn chưa nhập đủ thông tin'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sqlCheck="SELECT * FROM sanpham WHERE ten_sp='$ten_sp'";
	$rlCheck=mysqli_query($conn,$sqlCheck);
	$Check=mysqli_num_rows($rlCheck);
	if ($Check > 0) {
		echo "<script>alert('Lỗi ! Tên sản phẩm đã tồn tại'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$hinhanh_ten=$hinhanh['name'];
	move_uploaded_file($hinhanh['tmp_name'], '../../../../img/product/'.$time.$hinhanh_ten);

	$sqlInsert="INSERT INTO sanpham(id_dmsp,id_tt,ten_sp,soluong,gia_goc,gia,sale,hinhanh,noibat,mota) 
	            VALUES('$id_dmsp','$id_tt','$ten_sp','$soluong','$gia_goc','$gia','$sale','$time$hinhanh_ten','$noibat','$mota')";
	$rlInsert=mysqli_query($conn,$sqlInsert);
	$idInsert=mysqli_insert_id($conn);
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
			<li><a href="index.php">Quản lý sản phẩm</a></li>
			<li><a href="index.php">Sản phẩm</a></li>
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
			<i class="note">Lưu ý: Những trường có <b> (*) </b> không được để trống</i>
			<form action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label>Chọn danh mục <b class="note">(*)</b>:</label>
					<select name="id_dmsp">
						<option value="">--- Chọn danh mục sản phẩm ---</option>
						<?php
						$sqlDMSP="SELECT * FROM danhmuc_sp";
						$rlDMSP=mysqli_query($conn,$sqlDMSP);
						while ($row=mysqli_fetch_assoc($rlDMSP)) {
							$id_dmsp=$row['id_dmsp'];
							$ten_dmsp=$row['ten_dmsp'];
						
						?>
						<option value="<?php echo $id_dmsp; ?>"><?php echo $ten_dmsp; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label>Tên sản phẩm <b class="note">(*)</b>:</label>
					<input type="text" name="ten_sp" placeholder="Nhập tên sản phẩm...">
				</div>
				<div class="form-group">
					<label>Chọn thuộc tính <b class="note">(*)</b>:</label>
					<select name="id_tt">
						<option value="">--- Chọn thuộc tính sản phẩm ---</option>
						<?php
						$sqlTT="SELECT * FROM thuoctinh";
						$rlTT=mysqli_query($conn,$sqlTT);
						while ($rowTT=mysqli_fetch_assoc($rlTT)) {
							$id_tt=$rowTT['id_tt'];
							$ten_tt=$rowTT['ten_tt'];
						
						?>
						<option value="<?php echo $id_tt; ?>"><?php echo $ten_tt; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label>Số lượng <b class="note">(*)</b>:</label>
					<input type="number" name="soluong" placeholder="Nhập số lượng sản phẩm...">
				</div>
				<div class="form-group">
					<label>Giá sản phẩm <b class="note">(*)</b>:</label>
					<input type="number" name="gia_goc" placeholder="Nhập giá sản phẩm...">
				</div>
				<div class="form-group">
					<label>Giảm giá (%):</label>
					<input type="number" name="sale" value="0">
				</div>
				<div class="form-group">
					<label>Hình ảnh sản phẩm <b class="note">(*)</b>:</label>
					<input type="file" name="hinhanh">
				</div>
				<div class="form-group">
					<label>Nổi bật:</label>
					<select name="noibat">
						<option value="0">Không</option>
						<option value="1">Có</option>
					</select>
				</div>
				<div class="form-group">
					<label>Mô tả sản phẩm:</label>
					<textarea name="mota" placeholder="Mô tả sản phẩm..." class="ckeditor"></textarea>
				</div>
				<div class="form-group">
					<button type="submit" name="btn-submit" class="btn btn-primary"><i class="fa fa-plus"></i>Thêm mới</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php include("../../../layout/footer.php") ?>