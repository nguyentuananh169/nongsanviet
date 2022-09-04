<?php
session_start();
$open='ql-sanpham';
$where = "";
include("../../../../library/function.php");
include("../../../../connect.php");
if (isset($_GET['filter'])) {
	$param = "filter";
	$sr_cate = $_GET['sr_cate'];
	$sr_price = $_GET['sr_price'];
	if ($sr_cate != "") {
		$param.="&sr_cate=".$sr_cate."";
		// Nếu where rỗng thêm WHERE ngược lại thêm AND
		$where.=isset($where) && $where==""  ? 'WHERE sanpham.id_dmsp = '.$sr_cate : ' AND sanpham.id_dmsp = '.$sr_cate;
	}
	if ($sr_price != "") {
		$param.="&sr_price=".$sr_price."";
		switch ($sr_price) {
			case '1':
				$where.=isset($where) && $where==""  ? 'WHERE sanpham.gia < 100000' : ' AND sanpham.gia < 100000';
				break;
			case '2':
				$where.=isset($where) && $where==""  ? 'WHERE sanpham.gia >= 100000 AND sanpham.gia <= 500000' : ' AND sanpham.gia >= 100000 AND sanpham.gia <= 500000';
				break;
			case '3':
				$where.=isset($where) && $where==""  ? 'WHERE sanpham.gia >= 500000 AND sanpham.gia <= 1000000' : ' AND sanpham.gia >= 500000 AND sanpham.gia <= 1000000';
				break;
			case '4':
				$where.=isset($where) && $where==""  ? 'WHERE sanpham.gia > 1000000' : ' AND sanpham.gia > 1000000';
				break;
		}
	}
}
$sqlSP="SELECT * FROM sanpham ".$where;
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
			<li><a href="">Sản phẩm</a></li>
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
			<div class="filter-box">
				<form action="" method="get">
					<label>Lọc theo danh mục:</label>
					<select name="sr_cate">
						<option value="">--- Chọn tất cả ---</option>
						<?php
						$sqlCate = "SELECT * FROM danhmuc_sp";
						$rlCate = mysqli_query($conn,$sqlCate);
						while ($rowCate = mysqli_fetch_assoc($rlCate)) {
							$id_cate = $rowCate['id_dmsp'];
							$ten_cate = $rowCate['ten_dmsp'];
						
						?>
						<option value="<?php echo $id_cate ?>" <?php echo isset($_GET['sr_cate']) && $_GET['sr_cate'] == $id_cate ? 'selected' : '' ?>> <?php echo $ten_cate ?> </option>
						<?php } ?>
					</select>
					<label for="search_cate">Lọc theo giá:</label>
					<!-- <input type="number" name="sr_price" value="<?php echo $sr_price ?>"> -->
					<select name="sr_price">
						<option value="">--- Chọn tất cả ---</option>
						<option value="1" <?php echo isset($_GET['sr_price']) && $_GET['sr_price'] == 1 ? 'selected' : '' ?>> Dưới 100k </option>
						<option value="2" <?php echo isset($_GET['sr_price']) && $_GET['sr_price'] == 2 ? 'selected' : '' ?>> Từ 100k - 500k </option>
						<option value="3" <?php echo isset($_GET['sr_price']) && $_GET['sr_price'] == 3 ? 'selected' : '' ?>> Từ 500k - 1 triệu </option>
						<option value="4" <?php echo isset($_GET['sr_price']) && $_GET['sr_price'] == 4 ? 'selected' : '' ?>> trên 1 triệu </option>
					</select>
					<button type="submit" name="filter" class="btn btn-primary">Lọc ngay</button>
				</form>
			</div>
			<div class="num-pro">
				<span>Có <b><?php echo $totalSP; ?></b> sản phẩm trên <b><?php echo $totalPage; ?></b> trang</span>
			</div>
			<table border="1" cellpadding="0" cellspacing="0">
				<tr>
					<th>#</th>
					<th>Tên sản phẩm</th>
					<th>Danh mục</th>
					<th>Hình ảnh</th>
					<th>Giá</th>
					<th>Nổi bật</th>
					<th>Trạng thái</th>
					<th>Thao tác</th>
				</tr>
				<?php
				$stt = 1;
				$sql = "SELECT * FROM sanpham 
						INNER JOIN danhmuc_sp ON sanpham.id_dmsp = danhmuc_sp.id_dmsp 
						INNER JOIN thuoctinh ON sanpham.id_tt = thuoctinh.id_tt $where
						ORDER BY id_sp DESC LIMIT $start,$limit";
				$rl = mysqli_query($conn,$sql);
				while ($row = mysqli_fetch_assoc($rl)) {
					$id_sp = $row['id_sp'];
					$id_dmsp = $row['id_dmsp'];
					$ten_dmsp = $row['ten_dmsp'];
					$id_tt = $row['id_tt'];
					$ten_tt = $row['ten_tt'];
					$ten_sp = $row['ten_sp'];
					$gia_goc = $row['gia_goc'];
					$gia = $row['gia'];
					$soluong = $row['soluong'];
					$sale = $row['sale'];
					$hinhanh = $row['hinhanh'];
					$buyed = $row['buyed'];
					$view = $row['view'];
					$mota = $row['mota'];
					$noibat = $row['noibat'];
					$created_at = $row['created_at'];
					$updated_at = $row['updated_at'];
				
				?>
				<tr>
					<td><?php echo $stt; ?></td>
					<td><?php echo $ten_sp; ?></td>
					<td>
						<span class="btn-primary"><?php echo $ten_dmsp; ?></span>
					</td>
					<td><img src="../../../../img/product/<?php echo $hinhanh; ?>" width="50" height="50"></td>
					<td>
						<ul>
							<li>
								Giá gốc: <?php echo number_format($gia_goc); ?>đ / <?php echo $ten_tt; ?>
							</li>
							<li>
								Sale: <?php echo $sale; ?>%
							</li>
						</ul>
					</td>
					<td>
						<?php if ($noibat == 0): ?>
							<a class="btn-dark" href="noibat.php?id_sp=<?php echo $id_sp; ?>">không</a>
						<?php else: ?>
							<a class="btn-danger" href="noibat.php?id_sp=<?php echo $id_sp; ?>">Có</a>
						<?php endif; ?>
					</td>
					<td>
						<?php if ($soluong > 0): ?>
							<span class="con-hang">
								<i class="fa fa-check"></i>Còn hàng
							</span>
						<?php else: ?>
							<span class="het-hang">
								<i class="fa fa-times"></i>Hết hàng
							</span>
						<?php endif; ?>
					</td>
					<td>
						<label for="click-view-<?php echo $id_sp;?>" class="btn btn-primary"><i class="fa fa-eye"></i>Xem</label>
						<a class="btn-info" href="xua.php?id_sp=<?php echo $id_sp; ?>"><i class="fa fa-pencil-square-o"></i>Xửa</a>
						<a class="btn-danger" href="xoa.php?id_sp=<?php echo $id_sp; ?>"><i class="fa fa-times"></i>Xóa</a>
					</td>
				</tr>
				<input class="click-view" type="checkbox" id="click-view-<?php echo $id_sp;?>" hidden>
				<label for="click-view-<?php echo $id_sp;?>" class="overlay"></label>
				<div class="view-product">
					<div class="view-title-product">
						<h3>Xem chi tiết sản phẩm <strong><?php echo $ten_sp; ?></strong></h3>
						<label class="close" for="click-view-<?php echo $id_sp;?>">
							<i class="fa fa-times"></i>
						</label>
					</div>
					<div class="view-content-product">
						<div class="info-1">
							<div class="img-product">
								<img width="100%" height="100%" src="../../../../img/product/<?php echo $hinhanh; ?>">
							</div>
							<div class="detail-product">
								<ul>
									<li>Tên danh mục: <strong><?php echo $ten_dmsp; ?></strong></li>
									<li>Tên sản phẩm: <strong><?php echo $ten_sp; ?></strong></li>
									<li>Giá gốc: <?php echo number_format($gia_goc); ?>đ</li>
									<li>Thuộc tính: <?php echo $ten_tt; ?></li>
									<li>Sale: <?php echo $sale; ?>%</li>
									<li>Số lượng: <?php echo number_format($soluong); ?></li>
									<li>Trạng thái: 
										<?php if ($soluong > 0): ?>
											<span class="con-hang">
												<i class="fa fa-check"></i>Còn hàng
											</span>
										<?php else: ?>
											<span class="het-hang">
												<i class="fa fa-times"></i>Hết hàng
											</span>
										<?php endif; ?>
									</li>
									<li>Đã bán: <?php echo number_format($buyed); ?></li>
									<li>Lượt xem: <?php echo number_format($view); ?></li>
									<li>Nổi bật
										<?php if ($noibat == 0): ?>
											<a class="btn-dark" href="noibat.php?id_sp=<?php echo $id_sp; ?>">None</a>
										<?php else: ?>
											<a class="btn-danger" href="noibat.php?id_sp=<?php echo $id_sp; ?>">Hot</a>
										<?php endif; ?>
									</li>
									<li>Ngày tạo: <?php echo $created_at; ?></li>
									<li>Ngày cập nhật: <?php echo $updated_at; ?></li>
								</ul>
							</div>
						</div>
						<div class="info-2">
							<h3>Mô tả sản phẩm:</h3>
							<div class="motasp">
								<?php echo $mota; ?>
							</div>
						</div>
					</div>
				</div>
				<?php $stt++; } ?>
			</table>
			<!-- nếu số lượng sản phẩm = 0-->
			<?php if ($totalSP == 0) : ?>
			<div class="no-products">
				<span>Hiện tại không có sản phẩm nào phù hợp với yêu cầu của bạn!</span>
			</div>
			<?php endif ; ?>
		</div>

		<!-- phân trang -->
		<?php include("../../../../phantrang.php") ?>
	</div>
</div>
<?php include("../../../layout/footer.php") ?>