<?php
session_start(); 
include("connect.php");
include("library/function.php");
$open1="donhang";

if (isset($_GET['btn-submit'])) {
	$get_id_dh=$_GET['id_dh'];
	$sql="SELECT * FROM donhang WHERE id_dh='$get_id_dh'";
	$rl=mysqli_query($conn, $sql);
	$donhang=mysqli_fetch_assoc($rl);
	$kt_donhang=mysqli_num_rows($rl);
}else{
	header("location:kt_donhang.php");
	die();
}
?>
<?php include("layout/header.php") ?>
<div class="container">
	<div class="wide">
		<div class="path">
			<ul>
				<li><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Trang chủ</a></li>
				<li><a href="kt_donhang.php">Kiểm tra đơn hàng</a></li>
				<li><a href="">Xem chi tiết đơn hàng (<?php echo $get_id_dh; ?>)</a></li>
			</ul>
		</div>
	</div>
	<div class="wide">
		<?php if ($kt_donhang > 0) :?>
		<div class="info-order">
			<h3>Xem chi tiết đơn hàng (<?php echo $get_id_dh; ?>)</h3>
			<div class="order-dt">
				<h3>1.Thông tin nguời đặt hàng</h3>
				<table class="order-1" cellpadding="0" cellspacing="0">
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
			</div>
			<div class="order-dt">
				<h3>2.Danh sách sản phẩm đặt hàng</h3>
				<table class="order-2" cellpadding="0" cellspacing="0">
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
					$sql1="SELECT * FROM donhang_sp WHERE id_dh='$get_id_dh'";
					$rl1=mysqli_query($conn, $sql1);
					while ($row=mysqli_fetch_assoc($rl1)) {
						$tensp=$row['ten_dhsp'];
						$hinhanhsp=$row['hinhanh_dhsp'];
						$thuoctinh=$row['thuoctinh'];
						$gia=$row['gia_dhsp'];
						$soluong=$row['qty_dhsp'];
						$thanhtien=$row['thanhtien_dhsp'];
					
					?>
					<tr>
						<td><?php echo $stt; ?></td>
						<td><?php echo $tensp; ?></td>
						<td><img src="<?php echo base_url() ?>/img/product/<?php echo $hinhanhsp; ?>" height="50" width="50"></td>
						<td><?php echo $thuoctinh; ?></td>
						<td><?php echo number_format($gia); ?>đ</td>
						<td><?php echo number_format($soluong); ?></td>
						<td><?php echo number_format($thanhtien); ?>đ</td>
					</tr>
					<?php $stt++;} ?>
					<tr>
						<th colspan="7">Tổng tiền thanh toán: <?php echo number_format($donhang['tongtien']) ?>đ</th>
					</tr>
				</table>
			</div>
			<div class="order-dt">
				<h3>3.Lịch sử đơn hàng</h3>
				<table class="order-2" cellpadding="0" cellspacing="0">
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
						<td><?php echo $donhang['ten_kh'] ?></td>
						<td><?php echo $donhang['ghichu_kh'] ?></td>
						<td><?php echo $donhang['created_dh'] ?></td>
					</tr>
					<?php if ($donhang['trangthai'] == 1) :?>
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
		<?php else: ?>
		<div class="no-order">
			<i class="fa fa-times"></i>
			<span>Đơn hàng không tồn tại, vui lòng kiểm tra lại !</span>
			<a href="kt_donhang.php">Quay về</a>
		</div>
		<?php endif; ?>
	</div>
</div>
<?php include("layout/footer.php") ?>