<?php
session_start();
$open='ql-nguoidung';
include("../../../../library/function.php");
include("../../../../connect.php");
$sqlSP="SELECT * FROM thanhvien";
$rlSP=mysqli_query($conn,$sqlSP);
$totalSP=mysqli_num_rows($rlSP);
$limit=10;
$totalPage=ceil($totalSP / $limit);
$page= isset($_GET['page']) ? $_GET['page'] : '1';
$start= ($page-1)*$limit;
?>
<?php include("../../../layout/header.php") ?>
<div class="content-right">
	<div class="path">
		<ul>
			<li><a href="<?php echo base_url_admin() ?>">Trang chủ</a></li>
			<li><a href="">Quản lý thành viên</a></li>
			<li><a href="">Thành viên</a></li>
		</ul>
	</div>
	<div class="main-content">
		<div class="add-item">
			<a class="btn-primary" href="them.php"><i class="fa fa-plus"></i>Thêm mới</a>
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
					<th>Tên thành viên</th>
					<th>Email</th>
					<th>SĐT</th>
					<th>Địa chỉ</th>
					<th>Trạng thái (chặn)</th>
					<th>Ngày tạo</th>
					<th colspan="2">Thao tác</th>
				</tr>
				<?php
				$stt = 1;
				$sql = "SELECT * FROM thanhvien ORDER BY id_tv DESC LIMIT $start,$limit";
				$rl = mysqli_query($conn,$sql);
				while ($row = mysqli_fetch_assoc($rl)) {
					$id_tv = $row['id_tv'];
					$ten_tv = $row['ten_tv'];
					$email_tv = $row['email_tv'];
					$sdt_tv = $row['sdt_tv'];
					$diachi_tv = $row['diachi_tv'];
					$trangthai_tv = $row['trangthai_tv'];
					$created_tv = $row['created_tv'];
					$updated_tv = $row['updated_tv'];
				
				?>
				<tr>
					<td><?php echo $stt; ?></td>
					<td><?php echo $ten_tv; ?></td>
					<td><?php echo $email_tv; ?></td>
					<td><?php echo $sdt_tv; ?></td>
					<td><?php echo $diachi_tv; ?></td>
					<td>
						<?php if ($trangthai_tv == 0) : ?>
						<a class="btn-info" href="chan.php?id_tv=<?php echo $id_tv; ?>"><i class="fa fa-check"></i>không</a>
						<?php else: ?>
						<a class="btn-danger" href="chan.php?id_tv=<?php echo $id_tv; ?>"><i class="fa fa-lock"></i>Đã chặn</a>
						<?php endif; ?>
					</td>
					<td><?php echo $created_tv; ?></td>
					<td>
						<a class="btn-danger" href="xoa.php?id_tv=<?php echo $id_tv; ?>"><i class="fa fa-times"></i>Xóa</a>
					</td>
				</tr>
				<?php $stt++; } ?>
			</table>
		</div>
		<!-- phân trang -->
		<?php include("../../../../phantrang.php") ?>
	</div>
</div>
<?php include("../../../layout/footer.php") ?>