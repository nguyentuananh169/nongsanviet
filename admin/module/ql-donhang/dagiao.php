<?php 
session_start();
$open = 'ql-donhang';
include("../../../library/function.php");
include("../../../connect.php");
$sqlSP="SELECT * FROM donhang WHERE trangthai = 1";
$rlSP=mysqli_query($conn,$sqlSP);
$totalSP=mysqli_num_rows($rlSP);
$limit=10;
$totalPage=ceil($totalSP / $limit);
$page= isset($_GET['page']) ? $_GET['page'] : '1';
$start= ($page-1)*$limit;
?>
<?php include("../../layout/header.php");?>
<div class="content-right">
	<div class="path">
		<ul>
			<li><a href="<?php echo base_url_admin() ?>">Trang chủ</a></li>
			<li><a href="index.php">Quản lý đơn hàng</a></li>
			<li><a href="">Đơn hàng đã giao</a></li>
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
			<table border="1" cellpadding="0" cellspacing="0">
				<tr>
					<th>#</th>
					<th>Tên khách hàng</th>
					<th>Mã đơn hàng</th>
					<th>Tổng tiền</th>
					<th>Trạng thái</th>
					<th>Ngày tạo</th>
					<th>Thao tác</th>
				</tr>
				<?php
				$stt = 1;
				$sql = "SELECT * FROM donhang WHERE trangthai=1 ORDER BY id_dh DESC LIMIT $start,$limit";
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
					<td><label class="btn-info"><i class="fa fa-check"></i>Đã giao</label></td>
					<td><?php echo $created_dh; ?></td>
					<td>
						<a class="btn-primary" href="chitiet.php?id_dh=<?php echo $id_dh; ?>"><i class="fa fa-eye"></i>Xem</a>
					</td>
				</tr>
				<?php $stt++; } ?>
			</table>
		</div>
		<!-- phân trang -->
		<?php include("../../../phantrang.php") ?>
	</div>
</div>
<?php include("../../layout/footer.php");?>