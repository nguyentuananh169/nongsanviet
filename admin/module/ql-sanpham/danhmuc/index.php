<?php
session_start();
$open='ql-sanpham';
include("../../../../library/function.php");
include("../../../../connect.php");
$sqlSP="SELECT * FROM danhmuc_sp";
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
			<li><a href="">Quản lý sản phẩm</a></li>
			<li><a href="">Danh mục sản phẩm</a></li>
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
					<th>Tên danh mục</th>
					<th>Trạng thái</th>
					<th>Ngày tạo</th>
					<th>Ngày update</th>
					<th colspan="2">Thao tác</th>
				</tr>
				<?php
				$stt = 1;
				$sql = "SELECT * FROM danhmuc_sp ORDER BY id_dmsp DESC LIMIT $start,$limit";
				$rl = mysqli_query($conn,$sql);
				while ($row = mysqli_fetch_assoc($rl)) {
					$id_dmsp = $row['id_dmsp'];
					$ten_dmsp = $row['ten_dmsp'];
					$trangthai = $row['trangthai'];
					$created_dmsp = $row['created_dmsp'];
					$updated_dmsp = $row['updated_dmsp'];
				
				?>
				<tr>
					<td><?php echo $stt; ?></td>
					<td><?php echo $ten_dmsp; ?></td>
					<td>
						<?php if ($trangthai == 0) : ?>
							<a href="trangthai.php?id_dmsp=<?php echo $id_dmsp; ?>" class="btn-primary"><i class="fa fa-eye"></i>Hiện thị</a>
						<?php else : ?>
							<a href="trangthai.php?id_dmsp=<?php echo $id_dmsp; ?>" class="btn-dark"><i class="fa fa-eye-slash"></i>Đã ẩn</a>
						<?php endif; ?>
					</td>
					<td><?php echo $created_dmsp; ?></td>
					<td><?php echo $updated_dmsp; ?></td>
					<td>
						<a class="btn-info" href="xua.php?id_dmsp=<?php echo $id_dmsp; ?>"><i class="fa fa-pencil-square-o"></i>Xửa</a>
						<a class="btn-danger" href="xoa.php?id_dmsp=<?php echo $id_dmsp; ?>"><i class="fa fa-times"></i>Xóa</a>
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