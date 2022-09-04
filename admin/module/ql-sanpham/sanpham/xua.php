<?php
session_start();
$open='ql-sanpham';
$id_sp=$_GET['id_sp'];
include("../../../../library/function.php");
include("../../../../connect.php");
$sqlSP="SELECT * FROM sanpham WHERE id_sp='$id_sp'";
$rlSP=mysqli_query($conn,$sqlSP);
$sanpham=mysqli_fetch_assoc($rlSP);

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
	
	if ($id_dmsp=='' || $id_tt=='' || $ten_sp=='' || $soluong=='' || $gia_goc=='') {
		echo "<script>alert('Lỗi ! Bạn chưa nhập đủ thông tin'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sqlCheck="SELECT * FROM sanpham WHERE ten_sp='$ten_sp' AND id_sp!='$id_sp'";
	$rlCheck=mysqli_query($conn,$sqlCheck);
	$Check=mysqli_num_rows($rlCheck);
	if ($Check > 0) {
		echo "<script>alert('Lỗi ! Tên sản phẩm đã tồn tại'),location.href='javascript:history.go(-1)'</script>";
		die();
	}
	// Nếu hinh ảnh tồn tại và không rỗng thì lưu vào thư mục
	if ($hinhanh['name']) {
		$hinhanh_ten=$hinhanh['name'];
		move_uploaded_file($hinhanh['tmp_name'], '../../../../img/product/'.$time.$hinhanh_ten);
	}
    // Nếu hình ảnh tồn tại và không rỗng thì cập nhật cả hình ảnh và ngược lại
	if ($hinhanh['name']) {
		$sqlUpdate="UPDATE sanpham SET id_dmsp='$id_dmsp',id_tt='$id_tt',ten_sp='$ten_sp',soluong='$soluong',gia='$gia',gia_goc='$gia_goc',sale='$sale',hinhanh='$time$hinhanh_ten',noibat='$noibat',mota='$mota' WHERE id_sp='$id_sp'";
		$rlUpdate=mysqli_query($conn,$sqlUpdate);
	}else{
		$sqlUpdate2="UPDATE sanpham SET id_dmsp='$id_dmsp',id_tt='$id_tt',ten_sp='$ten_sp',soluong='$soluong',gia='$gia',gia_goc='$gia_goc',sale='$sale',noibat='$noibat',mota='$mota' WHERE id_sp='$id_sp'";
		$rlUpdate2=mysqli_query($conn,$sqlUpdate2);
	}

	$_SESSION['success']='Xửa sản phẩm " '.$ten_sp.' " thành công !';
	header("location:index.php");
	die();
}
?>
<?php include("../../../layout/header.php") ?>
<div class="content-right">
	<div class="path">
		<ul>
			<li><a href="<?php echo base_url_admin() ?>">Trang chủ</a></li>
			<li><a href="index.php">Quản lý sản phẩm</a></li>
			<li><a href="index.php">Sản phẩm</a></li>
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
						<option value="<?php echo $id_dmsp; ?>"<?php echo isset($sanpham['id_dmsp']) && $sanpham['id_dmsp']== $id_dmsp ? 'selected' : '' ?>>
							<?php echo $ten_dmsp; ?>
						</option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label>Tên sản phẩm <b class="note">(*)</b>:</label>
					<input type="text" name="ten_sp" placeholder="Nhập tên sản phẩm..." value="<?php echo $sanpham['ten_sp']; ?>">
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
						<option value="<?php echo $id_tt; ?>"<?php echo isset($sanpham['id_tt']) && $sanpham['id_tt']== $id_tt ? 'selected' : '' ?>>
							<?php echo $ten_tt; ?>
						</option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label>Số lượng <b class="note">(*)</b>:</label>
					<input type="number" name="soluong" placeholder="Nhập số lượng sản phẩm..."  value="<?php echo $sanpham['soluong']; ?>">
				</div>
				<div class="form-group">
					<label>Giá sản phẩm <b class="note">(*)</b>:</label>
					<input type="number" name="gia_goc" placeholder="Nhập giá sản phẩm..."  value="<?php echo $sanpham['gia_goc']; ?>">
				</div>
				<div class="form-group">
					<label>Giảm giá (%):</label>
					<input type="number" name="sale" value="<?php echo $sanpham['sale']; ?>">
				</div>
				<div class="form-group">
					<label>Hình ảnh sản phẩm:</label>
					<input type="file" name="hinhanh">
				</div>
				<div class="form-group">
					<label></label>
					<div class="img-product">
						<img src="../../../../img/product/<?php echo $sanpham['hinhanh']; ?>" width="50" height="50">
					</div>
				</div>
				<div class="form-group">
					<label>Nổi bật:</label>
					<select name="noibat">
						<option value="0" <?php echo isset($sanpham['noibat']) && $sanpham['noibat']== 0 ? 'selected' : '' ?>>
							Không
						</option>
						<option value="1" <?php echo isset($sanpham['noibat']) && $sanpham['noibat']== 1 ? 'selected' : '' ?>>
							Có
						</option>
					</select>
				</div>
				<div class="form-group">
					<label>Mô tả sản phẩm:</label>
					<textarea name="mota" class="ckeditor" placeholder="Mô tả sản phẩm...">
						<?php echo $sanpham['mota']; ?>
					</textarea>
				</div>
				<div class="form-group">
					<button type="submit" name="btn-submit" class="btn btn-primary"><i class="fa fa-edit"></i>Xửa sản phẩm</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include("../../../layout/footer.php") ?>