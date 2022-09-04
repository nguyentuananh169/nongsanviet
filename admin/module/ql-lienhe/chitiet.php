<?php 
session_start();
$open = 'ql-lienhe';
$id_lh = $_GET['id_lh'];
include("../../../library/function.php");
include("../../../connect.php");
$sql = "SELECT * FROM lienhe WHERE id_lh='$id_lh'";
$rl = mysqli_query($conn,$sql);
$lienhe = mysqli_fetch_assoc($rl);
?>
<?php include("../../layout/header.php");?>
<div class="content-right">
	<div class="path">
		<ul>
			<li><a href="<?php echo base_url_admin() ?>">Trang chủ</a></li>
			<li><a href="">Quản lý Liên hệ</a></li>
			<li><a href="">Chi tiết mã liên hệ <?php echo $id_lh; ?></a></li>
		</ul>
	</div>
	<div class="main-content">
		<div class="add-item">
			<a class="btn-primary" href="javascript:history.go(-1)"><i class="fa fa-undo"></i>Quay lại</a>
			<a class="btn-info" href="index.php"><i class="fa fa-shopping-bag"></i>Về trang liên hệ</a>
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
			<h3>1.Thông tin liên hệ</h3>
			<table class="detail-1" cellspacing="0" cellpadding="0">
				<tr>
					<td>Mã liên hệ</td>
					<td><?php echo $lienhe['id_lh']; ?></td>
				</tr>
				<tr>
					<td>Tên khách hàng</td>
					<td><?php echo $lienhe['ten']; ?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><?php echo $lienhe['email']; ?></td>
				</tr>
				<tr>
					<td>Điện thoại</td>
					<td><?php echo $lienhe['sdt']; ?></td>
				</tr>
				<tr>
					<td>Giới tính</td>
					<td>
						<?php 
							switch ($lienhe['gioitinh']) {
								case '0':
									echo "Nam";
									break;
								case '1':
									echo "Nữ";
									break;
							}
						?>
					</td>
				</tr>
				<tr>
					<td>Địa chỉ</td>
					<td><?php echo $lienhe['diachi'] ?></td>
				</tr>
				<tr>
					<td>Nội dung liên hệ</td>
					<td><?php echo $lienhe['noidung']; ?></td>
				</tr>
			</table>
			<h3>2.Trạng thái liên hệ</h3>
			<table class="detail-2" cellspacing="0" cellpadding="0">
				<tr>
					<th>#</th>
					<th>Trạng thái</th>
					<th>Người gửi</th>
					<th>Thời gian</th>
				</tr>
				<tr>
					<td>1</td>
					<td>Gửi nội dung liên hệ</td>
					<td><?php echo $lienhe['ten']; ?></td>
					<td><?php echo $lienhe['created_at']; ?></td>
				</tr>
				<?php if ($lienhe['trangthai'] == 0) : ?>
				<tr>
					<td>2</td>
					<td>
						<span class="text-warning">
							<i class="fa fa-spinner"></i> Chờ xử lý
						</span>
					</td>
					<td>Admin Shop</td>
					<td><?php echo $lienhe['updated_at']; ?></td>
				</tr>
				<?php else : ?>
				<tr>
					<td>2</td>
					<td>
						<span class="success">
							<i class="fa fa-check"></i> Đã xử lý
						</span>
					</td>
					<td>Admin Shop</td>
					<td><?php echo $lienhe['updated_at']; ?></td>
				</tr>
				<?php endif; ?>
			</table>
		</div>
	</div>
</div>
<?php include("../../layout/footer.php");?>