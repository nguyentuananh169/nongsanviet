<?php  
session_start();
$open='tintuc';
include("../library/function.php");
include('../connect.php');
$get_id_dmtt=$_GET['id_dmtt'];
$sqlDM="SELECT * FROM danhmuc_tintuc WHERE id_dmtt='$get_id_dmtt'";
$rlDM=mysqli_query($conn,$sqlDM);
$danhmuc=mysqli_fetch_assoc($rlDM);
?>
<?php include('../layout/header.php'); ?>
<div class="container">
	<div class="wide">
		<div class="path">
			<ul>
				<li><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i>Trang chủ</a></li>
				<li><a href="<?php echo base_url() ?>/tintuc">Tin tức</a></li>
				<li><a href=""><?php echo $danhmuc['ten_dmtt']; ?></a></li>
			</ul>
		</div>
		<div class="page-news">
			<div class="page-news-left">
				<?php
				$sqlNews="SELECT * FROM tintuc INNER JOIN danhmuc_tintuc ON tintuc.id_dmtt = danhmuc_tintuc.id_dmtt WHERE tintuc.id_dmtt='$get_id_dmtt' ORDER BY id_tt DESC";
				$rlNews=mysqli_query($conn,$sqlNews);
				while ($row=mysqli_fetch_assoc($rlNews)) {
					$id_tt=$row['id_tt'];
					$tieude=$row['tieude'];
					$hinhanh=$row['hinhanh'];
					$tomtat=$row['tomtat'];
					$created_tt=$row['created_tt'];
					$id_dmtt=$row['id_dmtt'];
					$ten_dmtt=$row['ten_dmtt'];
				
				?>
				<div class="news-item">
					<div class="news-item-img">
						<a href="chitiet_tt.php?id_tt=<?php echo $id_tt; ?>&id_dmtt=<?php echo $id_dmtt; ?>">
							<img src="<?php echo base_url() ?>/img/news/<?php echo $hinhanh; ?>" width="100%" height="100%">
						</a>
					</div>
					<div class="news-item-content">
						<div class="news-item-title">
							<a href="chitiet_tt.php?id_tt=<?php echo $id_tt; ?>&id_dmtt=<?php echo $id_dmtt; ?>"><?php echo $tieude; ?></a>
						</div>
						<div class="news-item-meta">
							<a href=""><?php echo $ten_dmtt; ?></a>
							<span><?php echo $created_tt; ?></span>
						</div>
						<div class="news-item-sumary">
							<span><?php echo $tomtat; ?></span>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="page-news-right">
				<div class="page-news-category">
					<div class="news-category-title">
						<h4>DANH MỤC TIN TỨC</h4>
					</div>
					<div class="news-category-body">
						<ul>
							<?php
							$sqlDM="SELECT * FROM danhmuc_tintuc WHERE trangthai = 0";
							$rlDM=mysqli_query($conn,$sqlDM);
							while ($row2=mysqli_fetch_assoc($rlDM)) {
								$id_dmtt2=$row2['id_dmtt'];
								$ten_dmtt2=$row2['ten_dmtt'];
							
							?>
							<li class="<?php echo isset($get_id_dmtt) && $get_id_dmtt == $id_dmtt2 ? 'active' : '' ?>">
								<a href="danhmuc.php?id_dmtt=<?php echo $id_dmtt2; ?>">
									<?php echo $ten_dmtt2; ?>	
								</a>
							</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div class="page-news-category">
					<div class="news-category-title">
						<h4>BÀI VIẾT ĐÁNH CHÚ Ý</h4>
					</div>
					<?php
					$sqlNews3="SELECT * FROM tintuc INNER JOIN danhmuc_tintuc ON tintuc.id_dmtt = danhmuc_tintuc.id_dmtt WHERE trangthai_tt = 0 ORDER BY view DESC LIMIT 6";
					$rlNews3=mysqli_query($conn,$sqlNews3);
					while ($row3=mysqli_fetch_assoc($rlNews3)) {
						$id_tt3=$row3['id_tt'];
						$tieude3=$row3['tieude'];
						$hinhanh3=$row3['hinhanh'];
						$created_tt3=$row3['created_tt'];
						$id_dmtt3=$row3['id_dmtt'];
						$ten_dmtt3=$row3['ten_dmtt'];
					
					?>
					<div class="news-category-item">
						<div class="news-category-item-img">
							<a href="chitiet_tt.php?id_tt=<?php echo $id_tt3; ?>&id_dmtt=<?php echo $id_dmtt3; ?>">
								<img src="<?php echo base_url() ?>/img/news/<?php echo $hinhanh3; ?>" width="100%" height="100%">
							</a>
						</div>
						<div class="news-category-item-content">
							<div class="news-category-item-title">
								<a href="chitiet_tt.php?id_tt=<?php echo $id_tt3; ?>&id_dmtt=<?php echo $id_dmtt3; ?>"><?php echo substr($tieude3, 0,103); ?></a>
							</div>
							<div class="news-category-item-meta">
								<a href="danhmuc.php?id_dmtt=<?php echo $id_dmtt3; ?>"><?php echo $ten_dmtt3; ?></a>
								<span><?php echo $created_tt3; ?></span>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include('../layout/footer.php'); ?>