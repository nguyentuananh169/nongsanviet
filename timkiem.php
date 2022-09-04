<?php
session_start();
include("connect.php");
include("library/function.php");

if (isset($_GET['btn-search'])) {
	$keyword=$_GET['keyword'];

	if ($keyword=='') {
		echo "<script>alert('Lỗi ! Bạn chưa nhập từ khóa tìm kiếm'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sql="SELECT * FROM sanpham WHERE ten_sp LIKE '%$keyword%'";
	$rl=mysqli_query($conn,$sql);
	$number=mysqli_num_rows($rl);

}
?>
<?php include("layout/header.php") ?>
<div class="container">
	<div class="wide">
		<div class="path">
			<ul>
				<li><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Trang chủ</a></li>
				<li><a href="">Tìm kiếm</a></li>
				<li><a href="">Từ khóa: <?php echo $keyword ?></a></li>
			</ul>
		</div>
		<div class="title-product">
			<i class="fa fa-caret-right"></i>
			<span>kết quả tìm kiếm (<?php echo $number; ?>)</span>
		</div>
		<div class="list-product">
			<div class="row">
				<?php
				$sql1="SELECT * FROM sanpham 
				INNER JOIN thuoctinh ON sanpham.id_tt = thuoctinh.id_tt 
				WHERE ten_sp LIKE '%$keyword%'";
				$rl1=mysqli_query($conn,$sql1);
				while ($row=mysqli_fetch_assoc($rl1)) {
					$id_sp = $row['id_sp'];
					$id_dmsp = $row['id_dmsp'];
					$id_tt = $row['id_tt'];
					$ten_tt = $row['ten_tt'];
					$ten_sp = $row['ten_sp'];
					$gia = $row['gia'];
					$sale = $row['sale'];
					$hinhanh = $row['hinhanh'];
					$buyed = $row['buyed'];
					$view = $row['view'];
					$noibat = $row['noibat'];
				
				?>
				<div class="product">
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
							<?php if ($sale > 0) :
								$giam_gia = ($gia * $sale) / 100;
								$gia_km = $gia - $giam_gia;
							?>
							<span><?php echo number_format($gia_km); ?>đ/<?php echo $ten_tt; ?></span>
							<strike><?php echo number_format($gia); ?>đ</strike>
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
	</div>
</div>
<?php include("layout/footer.php") ?>