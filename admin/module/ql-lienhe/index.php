<?php 
session_start();
$open = 'ql-lienhe';
include("../../../library/function.php");
include("../../../connect.php");
// phân trang
$sqlSP="SELECT * FROM lienhe WHERE trangthai = 0";
$rlSP=mysqli_query($conn,$sqlSP);
$totalSP=mysqli_num_rows($rlSP);
$limit=10;
$totalPage=ceil($totalSP / $limit);
$page= isset($_GET['page']) ? $_GET['page'] : '1';
$start= ($page-1)*$limit;
/*------------------------------------------*/

$sqlContact1 = "SELECT * FROM lienhe WHERE trangthai=1";
$rlContact1 = mysqli_query($conn,$sqlContact1);
$contact1 = mysqli_num_rows($rlContact1);
/*------------------------------------*/
?>
<?php include("../../layout/header.php");?>
<div class="content-right">
	<div class="path">
		<ul>
			<li><a href="<?php echo base_url_admin() ?>">Trang chủ</a></li>
			<li><a href="">Quản lý liên hệ</a></li>
			<li><a href="">Liên hệ chờ xử lý</a></li>
		</ul>
	</div>
	<div class="main-content">
		<div class="add-item">
			<a class="btn-primary" href="daxuly.php"><i class="fa fa-check"></i>Liên hệ đã xử lý (<?php echo $contact1; ?>)</a>
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
					<th>Email</th>
					<th>SĐT</th>
					<th>Trạng thái</th>
					<th>Ngày tạo</th>
					<th colspan="2">Thao tác</th>
				</tr>
				<?php
				$stt = 1;
				$sql = "SELECT * FROM lienhe WHERE trangthai=0 ORDER BY id_lh DESC ";
				$rl = mysqli_query($conn,$sql);
				while ($row = mysqli_fetch_assoc($rl)) {
					$id_lh = $row['id_lh'];
					$ten = $row['ten'];
					$email = $row['email'];
					$sdt = $row['sdt'];
					$trangthai = $row['trangthai'];
					$created_at = $row['created_at'];
				
				?>
				<tr>
					<td><?php echo $stt; ?></td>
					<td><?php echo $ten; ?></td>
					<td><?php echo $email; ?></td>
					<td><?php echo $sdt; ?></td>
					<td><label class="btn-warning"><i class="fa fa-spinner"></i>Chờ xử lý</label></td>
					<td><?php echo $created_at; ?></td>
					<td>
						<a class="btn-primary" href="chitiet.php?id_lh=<?php echo $id_lh; ?>"><i class="fa fa-eye"></i>Xem</a>
						<a class="btn-info" href="xuly.php?id_lh=<?php echo $id_lh; ?>"><i class="fa fa-check"></i>Đã xử lý</a>
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