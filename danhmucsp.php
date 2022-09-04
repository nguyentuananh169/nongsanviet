<?php
session_start();
include("connect.php");
include("library/function.php");
$get_id_dmsp=$_GET['id_dmsp'];
$open=$get_id_dmsp;
$param="id_dmsp=".$get_id_dmsp;
$where="";
if (isset($_GET['filter'])) {
	$param.="&filter";
	$namePro = $_GET['name-pro'];
	$pricePro = $_GET['price-pro'];
	$hotPro = $_GET['hot-pro'];
	$salePro = $_GET['sale-pro'];

	if ($namePro != "") {
		$param .= "&name-pro=".$namePro;
		$where .= " AND ten_sp like '%".$namePro."%'";
	}

	if ($pricePro != "") {
		$param .= "&price-pro=".$pricePro;
		switch ($pricePro) {
			case '1':
				$where .= " AND gia < 100000";
				break;
			case '2':
				$where .= " AND gia >= 100000 AND gia <= 500000";
				break;
			case '3':
				$where .= " AND gia >= 500000 AND gia <= 1000000";
				break;
			case '4':
				$where .= " AND gia > 1000000";
				break;
		}
	}

	if ($hotPro != "") {
		$param .= "&hot-pro=".$hotPro;
		switch ($hotPro) {
			case '1':
				$where .= " AND noibat = 1";
				break;
			case '2':
				$where .= " AND noibat = 0";
				break;
		}
	}

	if ($salePro != "") {
		$param .= "&sale-pro=".$salePro;
		switch ($salePro) {
			case '1':
				$where .= " AND sale > 0";
				break;
			case '2':
				$where .= " AND sale = 0";
				break;
		}
	}

}

$sqlSP="SELECT * FROM sanpham WHERE id_dmsp='$get_id_dmsp' ".$where;
$rlSP=mysqli_query($conn,$sqlSP);
$totalSP=mysqli_num_rows($rlSP);
$limit=8;
$totalPage=ceil($totalSP / $limit);
$page= isset($_GET['page']) ? $_GET['page'] : '1';
$start= ($page-1)*$limit;

$sql1="SELECT * FROM danhmuc_sp WHERE id_dmsp='$get_id_dmsp'";
$rl1=mysqli_query($conn,$sql1);
$data=mysqli_fetch_assoc($rl1);
?>
<?php include("layout/header.php") ?>
<div class="container">
	<div class="wide">
		<div class="path">
			<ul>
				<li><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Trang chủ</a></li>
				<li><a href=""><?php echo $data['ten_dmsp'] ?></a></li>
			</ul>
		</div>
		<div class="overlay-container"></div>
		<div class="container-cate-pro">
			<div class="container-left">
				<div class="title-product">
					<i class="fa fa-caret-right"></i>
					<span>Bộ lọc sản phẩm</span>
				</div>
				<form action="" method="get">
					<div class="filter-box">
						<div class="filter-item">
							<div class="filter-title">
								<span>Tên sản phẩm</span>
							</div>
							<div class="filter-value">
								<input type="text" name="name-pro" placeholder="Nhập tên sản phẩm ..." value="<?php echo $namePro ?>">
								<input type="text" name="id_dmsp" hidden value="<?php echo $get_id_dmsp; ?>">
							</div>
						</div>
						<div class="filter-item">
							<div class="filter-title">
								<span>Mức giá </span>
							</div>
							<div class="filter-value">
								<input type="radio" name="price-pro" value="" id="price-0" <?php echo !isset($pricePro) || $pricePro == "" ? 'checked' : '' ?>>
								<label for="price-0">Tất cả</label>
							</div>
							<div class="filter-value">
								<input type="radio" name="price-pro" value="1" id="price-1" <?php echo isset($pricePro) && $pricePro == 1 ? 'checked' : '' ?>>
								<label for="price-1">Dưới 100k</label>
							</div>
							<div class="filter-value">
								<input type="radio" name="price-pro" value="2" id="price-2" <?php echo isset($pricePro) && $pricePro == 2 ? 'checked' : '' ?>>
								<label for="price-2">Từ 100k - 500k</label>
							</div>
							<div class="filter-value">
								<input type="radio" name="price-pro" value="3" id="price-3" <?php echo isset($pricePro) && $pricePro == 3 ? 'checked' : '' ?>>
								<label for="price-3">Từ 500k - 1 triệu</label>
							</div>
							<div class="filter-value">
								<input type="radio" name="price-pro" value="4" id="price-4" <?php echo isset($pricePro) && $pricePro == 4 ? 'checked' : '' ?>>
								<label for="price-4">Trên 1 triệu</label>
							</div>
						</div>
						<div class="filter-item">
							<div class="filter-title">
								<span>Sản phẩm nổi bật</span>
							</div>
							<div class="filter-value">
								<input type="radio" name="hot-pro" value="" id="hot-0" <?php echo !isset($hotPro) || $hotPro == "" ? 'checked' : '' ?>>
								<label for="hot-0">Tất cả</label>
							</div>
							<div class="filter-value">
								<input type="radio" name="hot-pro" value="1" id="hot-1" <?php echo isset($hotPro) && $hotPro == 1 ? 'checked' : '' ?>>
								<label for="hot-1">Có</label>
							</div>
							<div class="filter-value">
								<input type="radio" name="hot-pro" value="2" id="hot-2" <?php echo isset($hotPro) && $hotPro == 2 ? 'checked' : '' ?>>
								<label for="hot-2">không</label>
							</div>
						</div>
						<div class="filter-item">
							<div class="filter-title">
								<span>Sản phẩm khuyến mãi</span>
							</div>
							<div class="filter-value">
								<input type="radio" name="sale-pro" value="" id="sale-0" <?php echo !isset($salePro) || $salePro == "" ? 'checked' : '' ?>>
								<label for="sale-0">Tất cả</label>
							</div>
							<div class="filter-value">
								<input type="radio" name="sale-pro" value="1" id="sale-1" <?php echo isset($salePro) && $salePro == 1 ? 'checked' : '' ?>>
								<label for="sale-1">Có</label>
							</div>
							<div class="filter-value">
								<input type="radio" name="sale-pro" value="2" id="sale-2" <?php echo isset($salePro) && $salePro == 2 ? 'checked' : '' ?>>
								<label for="sale-2">không</label>
							</div>
						</div>
						<button type="submit" name="filter" class="btn btn-primary"><i class="fa fa-search"></i>Lọc ngay</button>
						<button type="button" class="btn btn-danger close-filter"><i class="fa fa-times"></i> Đóng bộ lọc</button>
					</div>
				</form>
			</div>
			<div class="container-right">
				<div class="title-product">
					<i class="fa fa-caret-right"></i>
					<span><?php echo $data['ten_dmsp'] ?></span>
				</div>
				<button id="show-filter"><i class="fa fa-filter"></i>Bộ lọc sản phẩm</button>
				<div class="num-pro">
					<span>Có <b><?php echo $totalSP ?></b> sản phẩm trên <b><?php echo $totalPage ?></b> trang</span>
				</div>
				<div class="list-product">
					<div class="row">
						<?php
						$sql="SELECT * FROM sanpham 
						INNER JOIN thuoctinh ON sanpham.id_tt = thuoctinh.id_tt 
						WHERE id_dmsp='$get_id_dmsp' $where ORDER BY id_sp DESC LIMIT $start,$limit";
						$rl=mysqli_query($conn,$sql);
						while ($row=mysqli_fetch_assoc($rl)) {
							$id_sp = $row['id_sp'];
							$id_dmsp = $row['id_dmsp'];
							$id_tt = $row['id_tt'];
							$ten_tt = $row['ten_tt'];
							$ten_sp = $row['ten_sp'];
							$gia_goc = $row['gia_goc'];
							$gia = $row['gia'];
							$sale = $row['sale'];
							$hinhanh = $row['hinhanh'];
							$buyed = $row['buyed'];
							$view = $row['view'];
							$noibat = $row['noibat'];
						
						?>
						<div class="product ct">
							<div class="content-product">
								<div class="img-product">
									<a href="chitietsp.php?id_sp=<?php echo $id_sp; ?>&id_dmsp=<?php echo $id_dmsp; ?>">
										<img src="img/product/<?php echo $hinhanh; ?>" width="100%" height="100%">
									</a>
									<?php if ($sale > 0) { ?>
									<span class="sale-product">- <?php echo $sale; ?>%</span>
									<?php } ?>

									<?php if ($noibat > 0) { ?>
									<span class="hot-product">Hot</span>
									<?php } ?>
								</div>
								<div class="name-product">
									<a href="chitietsp.php?id_sp=<?php echo $id_sp; ?>&id_dmsp=<?php echo $id_dmsp; ?>">
										<?php echo $ten_sp; ?>
									</a>
								</div>
								<div class="price-product">
									<?php if ($sale > 0) :?>
									<span><?php echo number_format($gia); ?>đ/<?php echo $ten_tt; ?></span>
									<strike><?php echo number_format($gia_goc); ?>đ</strike>
									<!--  -->
									<?php else: ?>
									<span><?php echo number_format($gia); ?>đ/<?php echo $ten_tt; ?></span>
									<?php endif; ?>
								</div>
								<div class="buyed">
									<span>Đã bán: <?php echo number_format($buyed); ?></span>
								</div>
								<div class="view">
									<span>Lượt xem: <?php echo number_format($view); ?></span>
								</div>
						    </div>
						</div>
						<?php } ?>
					</div>
				</div>
				<!-- phân trang -->
				<?php include("phantrang.php") ?>
				<?php if ($totalSP == 0) : ?>
				<div class="no-products">
					<span>Hiện tại không có sản phẩm nào phù hợp với yêu cầu của bạn!</span>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php include("layout/footer.php") ?>
<script>
	var btnFilter = document.querySelector('#show-filter')
	var filterBox = document.querySelector('.container-left')
	var btnCloseFilter = document.querySelector('.close-filter')
	var overlayContainer = document.querySelector('.overlay-container')
	
	btnFilter.addEventListener('click', function(){
		filterBox.classList.add('show')
		overlayContainer.classList.add('show')
	})
	btnCloseFilter.addEventListener('click', function(){
		filterBox.classList.remove('show')
		overlayContainer.classList.remove('show')
	})
	overlayContainer.addEventListener('click', function(){
		filterBox.classList.remove('show')
		overlayContainer.classList.remove('show')
	})
</script>