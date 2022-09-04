<?php
session_start(); 
include("connect.php");
include("library/function.php");
$open="trangchu";
$sqlDMSP="SELECT * FROM danhmuc_sp WHERE trangthai = 0";
$rlDMSP = mysqli_query($conn,$sqlDMSP);
?>
<?php include("layout/header.php") ?> 
<div class="container">
	<div class="wide">
		<div class="banner">
			<a href=""><img src="img/banner/banner.jpg" style="width: 100%; height: 100%; object-fit: cover"></a>
		</div>
	</div>
	<?php
	while ($dmsp = mysqli_fetch_assoc($rlDMSP)) {
		$id_dmsp = $dmsp['id_dmsp'];
		$ten_dmsp= $dmsp['ten_dmsp'];
	
	?>
	<div class="wide">
		<div class="title-product">
			<i class="fa fa-caret-right"></i>
			<span><?php echo $ten_dmsp; ?></span>
		</div>
		<div class="list-product">
			<div class="row">
				<?php
				$sql="SELECT * FROM sanpham INNER JOIN thuoctinh ON sanpham.id_tt = thuoctinh.id_tt WHERE id_dmsp='$id_dmsp' ORDER BY id_sp DESC lIMIT 10";
				$rl=mysqli_query($conn,$sql);
				while ($row=mysqli_fetch_assoc($rl)) {
					$id_sp = $row['id_sp'];
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
	</div>
	<?php } ?>
	<div class="wide">
		<div class="title-product">
			<i class="fa fa-caret-right"></i>
			<span>Tin tức mới nhất</span>
		</div>
		<div class="list-news">
			<div class="row">
				<?php  
				$sqlTT = "SELECT * FROM tintuc 
						INNER JOIN danhmuc_tintuc ON tintuc.id_dmtt = danhmuc_tintuc.id_dmtt 
						INNER JOIN admin ON tintuc.id_ad = admin.id_ad 
						ORDER BY tintuc.id_tt DESC LIMIT 4";
				$rlTT=mysqli_query($conn,$sqlTT);
				while ($row2=mysqli_fetch_assoc($rlTT)) {
					$id_tt2 = $row2['id_tt'];
					$tieude2 = $row2['tieude'];
					$ten_ad2 = $row2['ten_ad'];
					$view2 = $row2['view'];
					$hinhanh2 = $row2['hinhanh'];
					$created_tt2 = $row2['created_tt'];
					$id_dmtt2 = $row2['id_dmtt'];
					$ten_dmtt2 = $row2['ten_dmtt'];
				
				?>
				<div class="news">
					<div class="news-body">
						<div class="news-img">
							<a href="tintuc/chitiet_tt.php?id_tt=<?php echo $id_tt2; ?>&id_dmtt=<?php echo $id_dmtt2; ?>">
								<img src="img/news/<?php echo $hinhanh2; ?>" width="100%" height="100%">
							</a>
							<div class="news-category">
								<a href="tintuc/danhmuc.php?id_dmtt=<?php echo $id_dmtt2; ?>"><?php echo $ten_dmtt2 ?></a>
							</div>
							<div class="news-views">
								<span><i class="fa fa-eye"></i> : <?php echo $view2; ?></span>
							</div>
						</div>
						<div class="news-title">
							<a href="tintuc/chitiet_tt.php?id_tt=<?php echo $id_tt2; ?>&id_dmtt=<?php echo $id_dmtt2; ?>"><?php echo substr($tieude2, 0, 155); ?></a>
						</div>
						<div class="news-meta">
							<div class="news-author">Đăng bởi: <?php echo $ten_ad2 ?></div>
							<div class="news-date">Ngày đăng: <?php echo $created_tt2 ?></div>
						</div>
						<div class="news-more">
							<a href="tintuc/chitiet_tt.php?id_tt=<?php echo $id_tt2; ?>&id_dmtt=<?php echo $id_dmtt2; ?>">Xem thêm</a>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php include("layout/footer.php") ?>
<script>
    function resizeBanner(){
    	var banner = document.querySelector('.banner')
    	banner.style.height = banner.clientWidth/2.7+'px'
    }
    resizeBanner()
    window.addEventListener('resize', resizeBanner)
</script>