<?php
session_start(); 
include("../library/function.php");
include("../connect.php");
$open1="donhang";
if (!isset($_SESSION['user'])) {
	header('location: '.base_url());
	die();
}
$sqlSP="SELECT * FROM donhang WHERE id_tv=".$_SESSION['user'];
$rlSP=mysqli_query($conn,$sqlSP);
$totalSP=mysqli_num_rows($rlSP);
$limit=10;
$totalPage=ceil($totalSP / $limit);
$page= isset($_GET['page']) ? $_GET['page'] : '1';
$start= ($page-1)*$limit;
?>
<?php include("../layout/header.php") ?>
<div class="container">
	<div class="wide">
		<div class="path">
			<ul>
				<li><a href="<?php echo base_url() ?>">Trang chủ</a></li>
				<li><a href="index.php">Bảng điều khiển</a></li>
				<li><a href="">Đơn hàng của bạn</a></li>
			</ul>
		</div>
	</div>
	<div class="wide info-user">
		<?php include("dashboard.php") ?>
		<div class="dashboard-main">
			<h3>Đơn hàng của bạn</h3>
			<div class="dashboard-main-content table-overflow">
				<div class="table-overflow">
					<table class="order" cellpadding="0" cellspacing="0">
						<tr>
							<th>#</th>
							<th>Mã đơn hàng</th>
							<th>Tổng tiền thanh toán</th>
							<th>Trạng thái</th>
							<th>Ngày đặt</th>
							<th>Thao tác</th>
						</tr>
						<?php 
						$stt=1;
						$sql="SELECT * FROM donhang WHERE id_tv=".$_SESSION['user']." ORDER BY id_dh DESC LIMIT $start,$limit";
						$rl=mysqli_query($conn, $sql);
						while ($row=mysqli_fetch_assoc($rl)) {
							$id_dh=$row['id_dh'];
							$tongtien=$row['tongtien'];
							$trangthai=$row['trangthai'];
							$created_dh=$row['created_dh'];
						
						?>
						<tr>
							<td><?php echo $stt; ?></td>
							<td>
								<a class="text-info" href="xem_dh.php?id_dh=<?php echo $id_dh ?>"><?php echo $id_dh; ?></a>
							</td>
							<td><?php echo number_format($tongtien); ?>đ</td>
							<td>
								<?php if ($trangthai == 0) :?>
								<span class="text-warning"><i class="fa fa-spinner"></i>Chờ xử lý</span>
								<?php elseif ($trangthai == 1) : ?>
								<span class="text-primary"><i class="fa fa-check"></i>Thành công</span>
								<?php elseif ($trangthai == 2) : ?>
								<span class="text-danger"><i class="fa fa-times"></i>Đã hủy</span>
								<?php endif; ?>
								
							</td>
							<td><?php echo $created_dh; ?></td>
							<td><a class="btn-info" href="xem_dh.php?id_dh=<?php echo $id_dh ?>"><i class="fa fa-eye"></i>Xem</a></td>
						</tr>
						<?php $stt++;} ?>
					</table>
				</div>
				<?php if ($totalSP == 0) : ?>
					<div class="no-products">
						<span>Hiện tại bạn chưa có đơn hàng nào trong danh sách!</span>
					</div>
				<?php endif; ?>

				<?php include("../phantrang.php"); ?>
			</div>
		</div>
	</div>
</div>
<?php include("../layout/footer.php") ?>