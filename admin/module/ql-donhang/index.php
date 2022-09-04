<?php 
session_start();
$open = 'ql-donhang';
include("../../../library/function.php");
include("../../../connect.php");
// phân trang
$sqlSP="SELECT * FROM donhang WHERE trangthai = 0";
$rlSP=mysqli_query($conn,$sqlSP);
$totalSP=mysqli_num_rows($rlSP);
$limit=10;
$totalPage=ceil($totalSP / $limit);
$page= isset($_GET['page']) ? $_GET['page'] : '1';
$start= ($page-1)*$limit;
/*------------------------------------------*/

$sqlOrder1 = "SELECT * FROM donhang WHERE trangthai=1";
$rlOrder1 = mysqli_query($conn,$sqlOrder1);
$order1 = mysqli_num_rows($rlOrder1);

$sqlOrder2 = "SELECT * FROM donhang WHERE trangthai=2";
$rlOrder2 = mysqli_query($conn,$sqlOrder2);
$order2 = mysqli_num_rows($rlOrder2);
/*------------------------------------*/
if (isset($_POST['btn-order-success'])) {
	$post_id_dh = $_POST['id_dh'];
	$post_ghichu = $_POST['ghichu'];

	$sqlUpdate1 = "UPDATE donhang SET trangthai=1,ghichu_adm='$post_ghichu' WHERE id_dh='$post_id_dh'";
	$rlUpdate1 = mysqli_query($conn,$sqlUpdate1);

	$_SESSION['success']  = 'Cập nhật trạng thái đơn hàng " đã giao " với mã đơn hàng '.$post_id_dh;
	header("location:index.php");
	die();
}
?>
<!------------------------------------->
<?php 
if (isset($_POST['btn-order-cancel'])) {
	$post_id_dh = $_POST['id_dh'];
	$post_lydo = $_POST['lydo'];
    // Lấy id sản phẩm và số lượng mua sản phẩm trong bảng donhang_sp
	$sqlCheckQty = "SELECT * FROM donhang_sp WHERE id_dh = $post_id_dh";
	$rlCheckQty = mysqli_query($conn,$sqlCheckQty);
	while ($row1 = mysqli_fetch_assoc($rlCheckQty)) {
		$id_sp = $row1['id_sp'];
		$ten_dhsp = $row1['ten_dhsp'];
		$qty_dhsp = $row1['qty_dhsp'];
	
	?>
		<?php
		// Lấy danh sách số lượng và số lượng đã bán trong bản sản phẩm theo id_sp trong bảng donhang_sp 
		$sqlSP = "SELECT * FROM sanpham WHERE id_sp = $id_sp";
		$rlSP = mysqli_query($conn,$sqlSP);
		$sanpham = mysqli_fetch_assoc($rlSP);
		
		$updatedBuyed = $sanpham['buyed'] - $qty_dhsp;
		$updatedSL = $sanpham['soluong'] + $qty_dhsp;
		// Update lại số lượng và số lượng đã bán trong bảng sanpham
		$sqlUpdatedSP = "UPDATE sanpham SET soluong = $updatedSL,buyed = $updatedBuyed WHERE id_sp = $id_sp";
		$rlUpdatedSP = mysqli_query($conn,$sqlUpdatedSP);
		?>
	<?php } ?>

<?php

$sqlUpdate2 = "UPDATE donhang SET trangthai=2,ghichu_adm='$post_lydo' WHERE id_dh='$post_id_dh'";
$rlUpdate2 = mysqli_query($conn,$sqlUpdate2);

$_SESSION['success'] = 'Cập nhật trạng thái đơn hàng " đã huỷ " với mã đơn hàng '.$post_id_dh;
header("location:index.php");
die();
}
?>
<?php include("../../layout/header.php");?>
<div class="content-right">
	<div class="path">
		<ul>
			<li><a href="<?php echo base_url_admin() ?>">Trang chủ</a></li>
			<li><a href="">Quản lý đơn hàng</a></li>
			<li><a href="">Đơn hàng chờ xử lý</a></li>
		</ul>
	</div>
	<div class="main-content">
		<div class="add-item">
			<a class="btn-primary" href="dagiao.php"><i class="fa fa-check"></i>Đơn hàng đã giao (<?php echo $order1 ?>)</a>
			<a class="btn-danger" href="dahuy.php"><i class="fa fa-times"></i>Đơn hàng đã hủy (<?php echo $order2 ?>)</a>
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
			<table border="1" cellpadding="0" cellspacing="0">
				<tr>
					<th>#</th>
					<th>Tên khách hàng</th>
					<th>Mã đơn hàng</th>
					<th>Tổng tiền</th>
					<th>Trạng thái</th>
					<th>Ngày tạo</th>
					<th colspan="2">Thao tác</th>
				</tr>
				<?php
				$stt = 1;
				$sql = "SELECT * FROM donhang WHERE trangthai=0 ORDER BY id_dh DESC ";
				$rl = mysqli_query($conn,$sql);
				while ($row = mysqli_fetch_assoc($rl)) {
					$id_dh = $row['id_dh'];
					$ten_kh = $row['ten_kh'];
					$email_kh = $row['email_kh'];
					$sdt_kh = $row['sdt_kh'];
					$tongtien = $row['tongtien'];
					$trangthai = $row['trangthai'];
					$created_dh = $row['created_dh'];
				
				?>
				<tr>
					<td><?php echo $stt; ?></td>
					<td><?php echo $ten_kh; ?></td>
					<td><a href="chitiet.php?id_dh=<?php echo $id_dh; ?>" style="text-decoration: none;font-weight: 500;color: #FFC107;"><?php echo $id_dh; ?></a></td>
					<td><?php echo number_format($tongtien); ?>đ</td>
					<td><label class="btn-warning"><i class="fa fa-spinner"></i>Chờ xử lý</label></td>
					<td><?php echo $created_dh; ?></td>
					<td>
						<a class="btn-primary" href="chitiet.php?id_dh=<?php echo $id_dh; ?>"><i class="fa fa-eye"></i>Xem</a>
						<label for="order-success-<?php echo $id_dh; ?>" class="btn btn-info"><i class="fa fa-check"></i>Đã giao</label>
						<label for="order-cancel-<?php echo $id_dh; ?>" class="btn btn-danger"><i class="fa fa-times"></i>Hủy đơn</label>
					</td>
				</tr>
				<!-- modal đơn hàng thành công -->
				<input class="show-modal-order" type="checkbox" id="order-success-<?php echo $id_dh; ?>" hidden>
				<label for="order-success-<?php echo $id_dh; ?>" class="overlay"></label>
				<div class="modal-order">
					<form action="" method="post">
						<div class="modal-header">
							<h3 class="order-success">Ghi chú đơn hàng mã số <?php echo $id_dh; ?></h3>
							<label for="order-success-<?php echo $id_dh; ?>"><i class="fa fa-times"></i></label>
						</div>
						<div class="modal-content">
							<input type="text" name="id_dh" readonly value="<?php echo $id_dh; ?>" hidden>
							<span>Nội dung ghi chú</span>
							<textarea name="ghichu" placeholder="Tối đa 100 ký tự..." maxlength="100"></textarea>
						</div>
						<div class="modal-bottom">
							<label for="order-success-<?php echo $id_dh; ?>" class="btn btn-info">
								<i class="fa fa-undo"></i>
								Quay lại
							</label>
							<button type="submit" name="btn-order-success" class="btn btn-primary">
								<i class="fa fa-check"></i>
								Đã giao
							</button>
						</div>
					</form>
				</div>
				<!-- modal hủy đơn hàng -->
				<input class="show-modal-order" type="checkbox" id="order-cancel-<?php echo $id_dh; ?>" hidden>
				<label for="order-cancel-<?php echo $id_dh; ?>" class="overlay"></label>
				<div class="modal-order">
					<form action="" method="post">
						<div class="modal-header">
							<h3 class="order-cancel">Hủy đơn hàng mã số <?php echo $id_dh; ?></h3>
							<label for="order-cancel-<?php echo $id_dh; ?>"><i class="fa fa-times"></i></label>
						</div>
						<div class="modal-content">
							<input type="text" name="id_dh" readonly value="<?php echo $id_dh; ?>" hidden>
							<span>Nội dung hủy đơn</span>
							<textarea name="lydo" placeholder="Tối đa 100 ký tự..." maxlength="100"></textarea>
						</div>
						<div class="modal-bottom">
							<label for="order-cancel-<?php echo $id_dh; ?>" class="btn btn-info">
								<i class="fa fa-undo"></i>
								Quay lại
							</label>
							<button type="submit" name="btn-order-cancel" class="btn btn-danger">
								<i class="fa fa-times"></i>
								Hủy đơn
							</button>
						</div>
					</form>
				</div>
				<?php $stt++; } ?>
			</table>
		</div>
		<!-- phân trang -->
		<?php include("../../../phantrang.php") ?>
	</div>
</div>
<?php include("../../layout/footer.php");?>