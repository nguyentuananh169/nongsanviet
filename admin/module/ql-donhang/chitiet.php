<?php 
session_start();
$open = 'ql-donhang';
$id_dh = $_GET['id_dh'];
include("../../../library/function.php");
include("../../../connect.php");
$sql = "SELECT * FROM donhang WHERE id_dh='$id_dh'";
$rl = mysqli_query($conn,$sql);
$donhang = mysqli_fetch_assoc($rl);
?>
<?php include("../../layout/header.php");?>
<div class="content-right">
	<div class="path">
		<ul>
			<li><a href="<?php echo base_url_admin() ?>">Trang chủ</a></li>
			<li><a href="">Quản lý đơn hàng</a></li>
			<li><a href="">Chi tiết đơn hàng <?php echo $id_dh; ?></a></li>
		</ul>
	</div>
	<div class="main-content">
		<div class="add-item">
			<a class="btn-primary" href="javascript:history.go(-1)"><i class="fa fa-undo"></i>Quay lại</a>
			<a class="btn-info" href="index.php"><i class="fa fa-shopping-bag"></i>Về trang đơn hàng</a>
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
		<div class="order-detail">
			<h3>1.Thông tin nguời đặt hàng</h3>
			<table class="detail-1" cellspacing="0" cellpadding="0">
				<tr>
					<td>Họ tên</td>
					<td><?php echo $donhang['ten_kh']; ?></td>
				</tr>
				<tr>
					<td>Điện thoại</td>
					<td><?php echo $donhang['sdt_kh']; ?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><?php echo $donhang['email_kh']; ?></td>
				</tr>
				<tr>
					<td>Phương thức</td>
					<td>Thanh toán khi nhận hàng</td>
				</tr>
				<tr>
					<td>Vận chuyển</td>
					<td>Miễn phí vận chuyển</td>
				</tr>
				<tr>
					<td>Địa chỉ</td>
					<td><?php echo $donhang['diachi_kh']; ?></td>
				</tr>
				<tr>
					<td>Ghi chú đặt hàng</td>
					<td><?php echo $donhang['ghichu_kh']; ?></td>
				</tr>
			</table>
			<!--  -->
			<h3>2.Danh sách sản phẩm đặt hàng</h3>
			<table class="detail-2" cellspacing="0" cellpadding="0">
				<tr>
					<th>#</th>
					<th>Tên sản phẩm</th>
					<th>Hình ảnh</th>
					<th>Thuộc tính</th>
					<th>Giá</th>
					<th>Số lượng</th>
					<th>Tổng(SL*G)</th>
				</tr>
				<?php
				$stt=1;
				$sql1="SELECT * FROM donhang_sp WHERE id_dh='$id_dh'";
				$rl1=mysqli_query($conn,$sql1);
				while ($row1=mysqli_fetch_assoc($rl1)) {
					$ten_dhsp=$row1['ten_dhsp'];
					$hinhanh_dhsp=$row1['hinhanh_dhsp'];
					$thuoctinh=$row1['thuoctinh'];
					$gia_dhsp=$row1['gia_dhsp'];
					$qty_dhsp=$row1['qty_dhsp'];
					$thanhtien_dhsp=$row1['thanhtien_dhsp'];
				
				?>
				<tr>
					<td><?php echo $stt; ?></td>
					<td><?php echo $ten_dhsp; ?></td>
					<td><img src="../../../img/product/<?php echo $hinhanh_dhsp; ?>" width="50px" height="50px"></td>
					<td><?php echo $thuoctinh; ?></td>
					<td><?php echo number_format($gia_dhsp); ?>đ</td>
					<td><?php echo number_format($qty_dhsp); ?></td>
					<td><?php echo number_format($thanhtien_dhsp); ?>đ</td>
				</tr>
				<?php $stt++;} ?>
				<tr>
					<th colspan="7">Tổng tiền thanh toán: <?php echo number_format($donhang['tongtien']); ?>đ</th>
				</tr>
			</table>
			<!--  -->
			<h3>3.Lịch sử đơn hàng</h3>
			<table class="detail-2" cellspacing="0" cellpadding="0">
				<tr>
					<th>#</th>
					<th>Trạng thái</th>
					<th>Người gửi</th>
					<th>Ghi chú</th>
					<th>Thời gian</th>
				</tr>
				<tr>
					<td>1</td>
					<td>Gửi yêu cầu đặt hàng</td>
					<td><?php echo $donhang['ten_kh']; ?></td>
					<td><?php echo $donhang['ghichu_kh']; ?></td>
					<td><?php echo $donhang['created_dh']; ?></td>
				</tr>
				<?php if ($donhang['trangthai'] == 0) :?>
				<tr>
					<td>2</td>
					<td><span class="text-warning"><i class="fa fa-spinner"></i>Chờ xử lý</span></td>
					<td>Admin Shop</td>
					<td><?php echo $donhang['ghichu_adm'] ?></td>
					<td><?php echo $donhang['updated_dh'] ?></td>
				</tr>
				<?php elseif ($donhang['trangthai'] == 1) :?>
				<tr>
					<td>2</td>
					<td><span class="text-primary"><i class="fa fa-check"></i>Thành công</span></td>
					<td>Admin Shop</td>
					<td><?php echo $donhang['ghichu_adm'] ?></td>
					<td><?php echo $donhang['updated_dh'] ?></td>
				</tr>
				<?php elseif ($donhang['trangthai'] == 2) :?>
				<tr>
					<td>2</td>
					<td><span class="text-danger"><i class="fa fa-times"></i>Đã hủy</span></td>
					<td>Admin Shop</td>
					<td><?php echo $donhang['ghichu_adm'] ?></td>
					<td><?php echo $donhang['updated_dh'] ?></td>
				</tr>
				<?php endif; ?>
			</table>
		</div>
	</div>
</div>
<?php include("../../layout/footer.php");?>