<?php
session_start(); 
include("../library/function.php");
include("../connect.php");
$open1="sp-yeuthich";
if (!isset($_SESSION['user'])) {
	header('location: '.base_url());
	die();
}
if (isset($_POST['remove-wish'])) {
	$post_id_sp=$_POST['id_sp'];

	$sqlDelete = "DELETE FROM sanpham_yt WHERE id_sp='$post_id_sp' AND id_tv=".$_SESSION['user'];
	$rlDelete = mysqli_query($conn,$sqlDelete);
	echo "<script>alert('Xóa sản phẩm khỏi danh sách yêu thích thành công !'),location.href='sp-yeuthich.php'</script>";
	die();
}

$sqlSP="SELECT * FROM sanpham INNER JOIN sanpham_yt ON sanpham.id_sp = sanpham_yt.id_sp  INNER JOIN thuoctinh ON sanpham.id_tt = thuoctinh.id_tt WHERE sanpham_yt.id_tv=".$_SESSION['user'];
$rlSP=mysqli_query($conn,$sqlSP);
$totalSP=mysqli_num_rows($rlSP);
$limit=8;
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
			<h3>Danh sách sản phẩm yêu thích</h3>
			<div class="dashboard-main-content">
				<div class="list-product">
					<div class="row">
						<?php
						$sql="SELECT * FROM sanpham 
						      INNER JOIN sanpham_yt ON sanpham.id_sp = sanpham_yt.id_sp 
						      INNER JOIN danhmuc_sp ON sanpham.id_dmsp = danhmuc_sp.id_dmsp 
						      INNER JOIN thuoctinh ON sanpham.id_tt = thuoctinh.id_tt 
						      WHERE sanpham_yt.id_tv= '".$_SESSION['user']."' ORDER BY sanpham_yt.id DESC LIMIT $start,$limit";
						$rl=mysqli_query($conn,$sql);
						while ( $row = mysqli_fetch_assoc($rl) ) {
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
									<a href="../chitietsp.php?id_sp=<?php echo $id_sp; ?>&id_dmsp=<?php echo $id_dmsp; ?>">
										<img src="../img/product/<?php echo $hinhanh; ?>" width="100%" height="100%">
									</a>
									<?php if ($sale > 0) { ?>
									<span class="sale-product">- <?php echo $sale; ?>%</span>
									<?php } ?>

									<?php if ($noibat > 0) { ?>
									<span class="hot-product">Hot</span>
									<?php } ?>
								</div>
								<div class="name-product">
									<a href="../chitietsp.php?id_sp=<?php echo $id_sp; ?>&id_dmsp=<?php echo $id_dmsp; ?>">
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
								<div class="remove-wish-list">
									<form action="" method="post">
										<input type="number" name="id_sp" readonly hidden value="<?php echo $id_sp ?>">
										<button type="submit" name="remove-wish" class="btn btn-danger">Xoá khỏi danh sách</button>
									</form>
								</div>
						    </div>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php if ($totalSP == 0) : ?>
					<div class="no-products">
						<span>Hiện tại chưa có sản phẩm nào trong danh sách yêu thích!</span>
					</div>
				<?php endif; ?>
				<?php include("../phantrang.php"); ?>
			</div>
		</div>
	</div>
</div>
<?php include("../layout/footer.php") ?>