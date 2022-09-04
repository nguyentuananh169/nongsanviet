<?php
session_start(); 
include("../library/function.php");
include("../connect.php");
$open1 = "binhluan";
if (!isset($_SESSION['user'])) {
	header('location: '.base_url());
	die();
}
$sqlSP = "SELECT * FROM binhluan_sp 
		INNER JOIN thanhvien ON binhluan_sp.id_tv = thanhvien.id_tv 
		INNER JOIN sanpham ON binhluan_sp.id_sp = sanpham.id_sp 
		WHERE binhluan_sp.parent_id = 0 AND binhluan_sp.id_tv=".$_SESSION['user'];
$rlSP = mysqli_query($conn,$sqlSP);
$totalSP = mysqli_num_rows($rlSP);
$limit = 5;
$totalPage = ceil($totalSP / $limit);
$page = isset($_GET['page']) ? $_GET['page'] : '1';
$start = ($page-1)*$limit;

if (isset($_POST['btn-submit'])) {
	$post_id_sp = $_POST['id_sp'];
	$post_id_cmt = $_POST['id_cmt'];
	$post_noidung_cmt = $_POST['noidung_cmt'];

	if ($post_noidung_cmt == "" || $post_id_sp == "" || $post_id_cmt == "") {
		echo "<script>alert('Lỗi ! Bạn phải nhập đủ nội dung !'),location.href='javascript:history.go(-1)'</script>";
		die();
	}

	$sqlInsertCmt="INSERT INTO binhluan_sp(id_sp, id_tv, parent_id, noidung) VALUES('$post_id_sp', '".$_SESSION['user']."', '$post_id_cmt', '$post_noidung_cmt')";
	$rlInsertCmt=mysqli_query($conn,$sqlInsertCmt);
	$idInsertCmt=mysqli_insert_id($conn);

	if ($idInsertCmt > 0) {
		echo "<script>alert('Gửi bình luận thành công !'),location.href='ql-binhluan.php'</script>";
		
	}else{
		echo "<script>alert('Gửi bình luận thất bại !'),location.href='ql-binhluan.php'</script>";
		
	}
	
}
?>
<?php include("../layout/header.php") ?>
<div class="container">
	<div class="wide">
		<div class="path">
			<ul>
				<li><a href="<?php echo base_url() ?>">Trang chủ</a></li>
				<li><a href="index.php">Bảng điều khiển</a></li>
				<li><a href="">Quản lý bình luận</a></li>
			</ul>
		</div>
	</div>
	<div class="wide info-user">
		<?php include("dashboard.php") ?>
		<div class="dashboard-main">
			<h3>Bình luận của bạn</h3>
			<div class="dashboard-main-content">
				<div class="comment-box">
					<?php 
					while ($row = mysqli_fetch_assoc($rlSP)) {
						$id_cmt = $row['id'];
						$ten_tv = $row['ten_tv'];
						$id_sp = $row['id_sp'];
						$ten_sp = $row['ten_sp'];
						$id_dmsp = $row['id_dmsp'];
						$hinhanh_sp = $row['hinhanh'];
						$noidung = $row['noidung'];
						$created_cmt = $row['created_at'];
					
					?>
					<div class="comment-box-item">
						<div class="comment-box-item-pro">
							<div class="img">
								<a href="../chitietsp.php?id_sp=<?php echo $id_sp ?>&id_dmsp=<?php echo $id_dmsp ?>">
									<img src="../img/product/<?php echo $hinhanh_sp ?>" alt="<?php echo $ten_sp ?>" width="100%" height="100%">
								</a>
							</div>
							<div class="name">
								<a href="../chitietsp.php?id_sp=<?php echo $id_sp ?>&id_dmsp=<?php echo $id_dmsp ?>"><?php echo $ten_sp ?></a>
							</div>
						</div>
						<div class="comment-box-item-content">
							<div class="top">
								<div class="time">
									<span class="name"><?php echo $ten_tv ?></span>
									<span>Ngày, <?php echo $created_cmt ?></span>
								</div>
								<div class="content">
									<span><?php echo $noidung ?></span>
									<?php 
									$sqlRepCmt = "SELECT * FROM binhluan_sp WHERE parent_id = '$id_cmt'";
									$rlRepCmt = mysqli_query($conn,$sqlRepCmt);
									$repCmt = mysqli_num_rows($rlRepCmt);
									if ($repCmt > 0) : ?>

									<a href="../chitietsp.php?id_sp=<?php echo $id_sp ?>&id_dmsp=<?php echo $id_dmsp ?>" class="pro-link">
										( Xem thêm <?php echo $repCmt ?> bình luận )
									</a>

									<?php endif; ?>
								</div>
							</div>
							<div class="bottom">
								<form action="" method="post">
									<input type="text" name="id_cmt" hidden readonly value="<?php echo $id_cmt ?>">
									<input type="text" name="id_sp" hidden readonly value="<?php echo $id_sp ?>">
									<textarea name="noidung_cmt" placeholder="Nhập bình luận của bạn..."></textarea>
									<button type="submit" class="btn btn-primary" name="btn-submit"><i class="fa fa-paper-plane-o"></i>Gửi bình luận</button>
								</form>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
				<?php if ($totalSP == 0) : ?>
					<div class="no-products">
						<span>Hiện tại bạn chưa có bình luận nào!</span>
					</div>
				<?php endif; ?>

				<?php include("../phantrang.php"); ?>
			</div>
		</div>
	</div>
</div>
<?php include("../layout/footer.php") ?>