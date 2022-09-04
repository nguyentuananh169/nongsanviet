<?php  
session_start();
include("../../../../library/function.php");
include('../../../../connect.php');
$open = 'ql-tintuc';
$get_id_tt = $_GET['id_tt'];
$sql = "SELECT * FROM tintuc WHERE id_tt = '$get_id_tt'";
$rl = mysqli_query($conn, $sql);
$tintuc = mysqli_fetch_assoc($rl);
?>
<?php include('../../../layout/header.php'); ?>
<div class="content-right">
	<div class="path">
		<ul>
			<li><a href="<?php echo base_url_admin() ?>">Trang chủ</a></li>
			<li><a href="<?php echo base_url_admin() ?>">Admin</a></li>
			<li><a href="">Quản lý tin tức</a></li>
			<li><a href="">Tin tức</a></li>
		</ul>
	</div>
	<div class="main-content">
		<div class="add-item">
			<a class="btn-primary" href="javascript:history.go(-1)"><i class="fa fa-undo"></i>Quay lại</a>
		</div>
		<div class="content">
			<div class="title-news">
				<h2><?php echo $tintuc['tieude'] ?></h2>
			</div>
			<div class="meta-news">
				<span>Bởi: <b><?php echo $tintuc['tacgia'] ?></b> - <?php echo $tintuc['created_tt'] ?></span>
				<p>Lượt xem: <?php echo $tintuc['view'] ?></p>
			</div>
			<div class="sumary-news">
				<span><?php echo $tintuc['tomtat'] ?></span>
			</div>
			<div class="content-news">
				<?php echo $tintuc['noidung'] ?>
			</div>
		</div>
	</div>
</div>
<?php include('../../../layout/footer.php'); ?>