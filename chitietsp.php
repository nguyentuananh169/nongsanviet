<?php
session_start();
include("connect.php");
include("library/function.php");
$get_id_sp=$_GET['id_sp'];
$get_id_dmsp=$_GET['id_dmsp'];
$open=$_GET['id_dmsp'];

$sql="SELECT * FROM sanpham 
INNER JOIN thuoctinh ON sanpham.id_tt = thuoctinh.id_tt 
WHERE id_sp='$get_id_sp'";
$rl=mysqli_query($conn,$sql);
$sanpham=mysqli_fetch_assoc($rl);

$view=$sanpham['view'] + 1;
$sql2="UPDATE sanpham SET view='$view' WHERE id_sp='$get_id_sp'";
$rl2=mysqli_query($conn,$sql2);

$sql3="SELECT * FROM danhmuc_sp WHERE id_dmsp='$get_id_dmsp'";
$rl3=mysqli_query($conn,$sql3);
$danhmuc_sp=mysqli_fetch_assoc($rl3);

$sql4 = "SELECT * FROM sanpham_yt WHERE id_sp='$get_id_sp' AND id_tv=".$_SESSION['user'];
$rl4 = mysqli_query($conn,$sql4);
$proWish = mysqli_num_rows($rl4);

if (isset($_POST['post_cmt'])) {
	if (!isset($_SESSION['user'])) {
		echo "<script>alert('Lỗi ! Bạn phải đăng nhập mới có thể sử dụng chức năng này !'),location.href='dangnhap.php'</script>";
		die();
	}

	$post_cmt_noidung = $_POST['post_cmt_noidung'];

	if ($post_cmt_noidung == "") {
		echo "<script>alert('Lỗi ! Bạn cần nhập đủ nội dung !'),location.href='chitietsp.php?id_sp=".$get_id_sp."&id_dmsp=".$get_id_dmsp."'</script>";
		exit();
	}

	$sqlInsertCmt = "INSERT INTO binhluan_sp(id_sp,id_tv,noidung) VALUES('$get_id_sp','".$_SESSION['user']."','$post_cmt_noidung')";
	$rlInsertCmt = mysqli_query($conn,$sqlInsertCmt);

	$id_insert_cmt = mysqli_insert_id($conn);

	if ($id_insert_cmt > 0) {
		echo "<script>alert('Gửi bình luận thành công !'),location.href='chitietsp.php?id_sp=".$get_id_sp."&id_dmsp=".$get_id_dmsp."'</script>";
		die();
	}else{
		echo "<script>alert('Gửi bình luận thất bại !'),location.href='chitietsp.php?id_sp=".$get_id_sp."&id_dmsp=".$get_id_dmsp."'</script>";
		die();
	}
}

if (isset($_POST['rep_cmt'])) {
	if (!isset($_SESSION['user'])) {
		echo "<script>alert('Lỗi ! Bạn phải đăng nhập mới có thể sử dụng chức năng này !'),location.href='dangnhap.php'</script>";
		die();
	}

	$id_cmt = $_POST['id_cmt'];
	$post_cmt_noidung = $_POST['post_cmt_noidung'];

	if ($post_cmt_noidung == "" || $id_cmt == "") {
		echo "<script>alert('Lỗi ! Bạn cần nhập đủ nội dung !'),location.href='chitietsp.php?id_sp=".$get_id_sp."&id_dmsp=".$get_id_dmsp."'</script>";
		die();
	}

	$sqlInsertCmt = "INSERT INTO binhluan_sp(id_sp,id_tv,parent_id,noidung) VALUES('$get_id_sp','".$_SESSION['user']."','$id_cmt','$post_cmt_noidung')";
	$rlInsertCmt = mysqli_query($conn,$sqlInsertCmt);

	$id_insert_cmt = mysqli_insert_id($conn);

	if ($id_insert_cmt > 0) {
		echo "<script>alert('Gửi bình luận thành công !'),location.href='chitietsp.php?id_sp=".$get_id_sp."&id_dmsp=".$get_id_dmsp."'</script>";
		die();
	}else{
		echo "<script>alert('Gửi bình luận thất bại !'),location.href='chitietsp.php?id_sp=".$get_id_sp."&id_dmsp=".$get_id_dmsp."'</script>";
		die();
	}
}
?>
<?php include("layout/header.php") ?>
<div class="container">
	<div class="wide">
		<div class="path">
			<ul>
				<li><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Trang chủ</a></li>
				<li><a href="danhmucsp.php?id_dmsp=<?php echo $get_id_dmsp; ?>"><?php echo $danhmuc_sp['ten_dmsp'] ?></a></li>
				<li><a href=""><?php echo $sanpham['ten_sp'] ?></a></li>
			</ul>
		</div>
		<div class="detail-product">
			<div class="pro-title">
				<div class="pro-name">
					<h3><?php echo $sanpham['ten_sp'] ?></h3>
				</div>
			</div>
			<div class="pro-content">
				<div class="pro-content-1">
					<div class="pro-img">
						<img src="img/product/<?php echo $sanpham['hinhanh']; ?>" width="100%" height="100%">
						<a class="pro-wish <?php echo $proWish > 0 ? 'active' : '' ?>" href="sp-yeuthich.php?id_sp=<?php echo $get_id_sp; ?>&id_dmsp=<?php echo $get_id_dmsp; ?>" title="<?php if($proWish > 0){echo "Xóa sản phẩm khỏi danh sách yêu thích";}else{echo "Thêm sản phẩm vào danh sách yêu thích";} ?>">
							<i class="fa fa-heart" ></i>
						</a>
					</div>
				</div>
				<div class="pro-content-2">
					<div class="pro-banner">
						<img src="img/banner/po1.png" width="100%" height="100px">
						<img src="img/banner/po2.png" width="100%" height="100px">
					</div>
					<div class="pro-price">
						<?php if ($sanpham['sale'] > 0) :?>
						<span><?php echo number_format($sanpham['gia']); ?>đ/<?php echo $sanpham['ten_tt']; ?></span>
						<strike><?php echo number_format($sanpham['gia_goc']); ?>đ</strike>
						<!--  -->
						<?php else: ?>
						<span><?php echo number_format($sanpham['gia']); ?>đ/<?php echo $sanpham['ten_tt']; ?></span>
						<?php endif; ?>
					</div>
					<div class="pro-status">
						<?php if ($sanpham['soluong'] > 0) :?>
						<span class="con-hang"><i class="fa fa-check"></i>Còn hàng</span>
						<?php else: ?>
						<span class="het-hang"><i class="fa fa-times"></i>Hết hàng</span>
						<?php endif; ?>
						<i>(<?php echo number_format($sanpham['soluong']); ?> số lượng có sẵn)</i>
					</div>

					<div class="pro-order">
						<form action="addgiohang.php" method="post">
							<div class="pro-input">
								<label>Số lượng mua:</label>
								<input type="text" name="id_sp" value="<?php echo $get_id_sp; ?>" hidden>
								<input type="number" name="qty" value="<?php echo isset($sanpham['soluong']) && $sanpham['soluong'] > 0 ? '1' : '0' ?>">
							</div>
							<div class="pro-button">
								<button type="submit" name="btn-submit">Thêm vào giỏ hàng</button>
							</div>
						</form>
					</div>

					<div class="pro-event">
						<h3>Khuyến mại</h3>
						<ul>
							<li><b>Bốc thăm 100% trúng thưởng</b> <strong>10 chỉ vàng, 200 suất lì xì 1 triệu và 5000 giải thưởng khác</strong> <b>từ ngày 20/1 đến 10/2</b></li>
							<li>Tháng khai trương – giảm thêm đến <strong>10%</strong> tại Hà Nội</li>
							<li>Giảm thêm <font>10%</font> khi mua hàng Online.</li>
						</ul>
					</div>
					<div class="pro-tuvan">
						<input type="text" placeholder="Tư vấn qua số điện thoại...">
						<button type="submit"><i class="fa fa-phone"></i>Đăng ký</button>
					</div>
					<div class="pro-hotline">
						<span>Gọi <a href="">0971.029.649</a> hoặc <a href="">0999.999.999</a></span>
						<p>để được tư vấn (Từ 8:00-22:00)</p>
					</div>
				</div>
				<div class="pro-content-3">
					<div class="pro-dv dv1">
						<ul>
							<li><strong>Sản phẩm được cung cấp bởi những thương hiệu uy tín</strong> <a href="">(Chi tiết)</a></li>
							<li>Tất cả sản phẩm bán ra đều <strong>cam kết chất lượng - an toàn - không chất độc hại - Tất cả sản phẩm đều đã được kiểm tra kỹ trước khi giao đến tay khách hàng</strong>. Khách hàng có thể đến shop để kiểm tra và mua trực tiếp</li>
						</ul>
					</div>
					<div class="pro-dv dv2">
						<ul>
							<li>111 Trần Đăng Ninh, Cầu Giấy, Hà Nội (09.7673.2468)</li>
							<li>446 Xã Đàn, Đống Đa, Hà Nội (096.111.2468)</li>
							<li>118 Thái hà, Đống Đa, Hà Nội (096.424.2468)</li>
							<li>312 Nguyễn Trãi, Trung Văn, Nam Từ Liêm, Hà Nội – Gần chợ Phùng Khoang (094.698.2468)</li>
							<li>380 Trần Phú, Ba Đình, TP.Thanh Hóa (096914.2468)</li>
							<li>107 Nguyễn Hữu Tiến – TT Đồng Văn – Duy Tiên – Hà Nam (0357.209.209)</li>
							<li>418 Lạch Tray, Ngô Quyền, Hải Phòng (0949.16.2468)</li>
						</ul>
					</div>
					<div class="pro-dv dv3">
						<ul>
							<li>Hỗ trợ trả góp cho các đơn hàng từ 10.000.000 trở lên</li>
							<li>Chỉ cần bằng lái xe & chứng minh thư</li>
							<li>Trả trước 50% nhận sản phẩm sau 5-15 phút</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="wide">
		<div class="pro-description">
			<div class="pro-description-title">
				<h3>Mô tả sản phẩm <b><?php echo $sanpham['ten_sp']; ?></b></h3>
			</div>
			<div class="pro-description-content">
				<?php if ($sanpham['mota']=='') : ?>
					<div class="pro-no-content">Nội dung đang được cập nhật ...</div>
				<?php else: ?>
					<div class="description-content">
						<?php echo $sanpham['mota']; ?>
					</div>
					<div class="btn-content">
						<button class="btn-more-content"><i class="fa fa-caret-down"></i> Xem thêm</button>
						<button class="btn-collapse-content"><i class="fa fa-caret-up"></i> Thu gọn</button>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="wide">
		<div class="title-product">
			<i class="fa fa-caret-right"></i>
			<span>Sản phẩm liên quan</span>
		</div>
		<div class="list-product">
			<div class="row">
				<?php
				$sql="SELECT * FROM sanpham INNER JOIN thuoctinh ON sanpham.id_tt =thuoctinh.id_tt WHERE sanpham.id_dmsp='$get_id_dmsp' AND sanpham.id_sp!='$get_id_sp' ORDER BY sanpham.id_sp DESC lIMIT 5";
				$rl=mysqli_query($conn,$sql);
				while ($row=mysqli_fetch_assoc($rl)) {
					$id_sp = $row['id_sp'];
					$id_dmsp = $row['id_dmsp'];
					$ten_sp = $row['ten_sp'];
					$gia_goc = $row['gia_goc'];
					$gia = $row['gia'];
					$sale = $row['sale'];
					$hinhanh = $row['hinhanh'];
					$buyed = $row['buyed'];
					$view = $row['view'];
					$noibat = $row['noibat'];
					$ten_tt = $row['ten_tt'];
				
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
	<div class="wide">
		<div class="comment-pro">
			<div class="comment-content lv1">
				<form action="" method="post">
					<h3>Hỏi & Đáp về sản phẩm <?php echo $sanpham['ten_sp']; ?></h3>
					<textarea name="post_cmt_noidung" placeholder="Nhập nội dung bình luận..."></textarea>
					<button type="submit" name="post_cmt" class="btn btn-primary">
						<i class="fa fa-paper-plane-o"></i>Gửi bình luận
					</button>
					<?php if (!isset($_SESSION['user'])) : ?>
					<i class="note">Lưu ý: Bạn phải đăng nhập mới có thể bình luận</i>
					<?php endif; ?>
				</form>
			</div>
			<div class="comment-list">
				<?php 
					$sqlCmt = "SELECT * FROM binhluan_sp INNER JOIN thanhvien ON binhluan_sp.id_tv = thanhvien.id_tv WHERE binhluan_sp.parent_id = 0 AND binhluan_sp.id_sp = '$get_id_sp' ORDER BY binhluan_sp.id DESC";
					$rlCmt = mysqli_query($conn,$sqlCmt);
					while ($rowCmt = mysqli_fetch_assoc($rlCmt)) {
						$id_cmt = $rowCmt['id'];
						$user_cmt = $rowCmt['ten_tv'];
						$created_cmt = $rowCmt['created_at'];
						$noidung_cmt = $rowCmt['noidung'];
					
				?>
				<div class="comment-item lv1">
					<div class="comment-item-avatar">
						<img src="img/icon/no-avt.png" alt="" width="100%" height="100%">
					</div>
					<div class="comment-item-content lv1">
						<div class="name"><?php echo $user_cmt ?></div>
						<div class="time"><?php echo $created_cmt ?></div>
						<div class="content"><?php echo $noidung_cmt ?></div>
						<div class="comment-list lv2">
							<?php 
								$sqlCmtLv2 = "SELECT * FROM binhluan_sp INNER JOIN thanhvien ON binhluan_sp.id_tv = thanhvien.id_tv WHERE binhluan_sp.parent_id = '$id_cmt' ORDER BY binhluan_sp.id ASC";
								$rlCmtLv2 = mysqli_query($conn,$sqlCmtLv2);
								while ($rowCmtLv2 = mysqli_fetch_assoc($rlCmtLv2)) {
									$id_cmt_lv2 = $rowCmtLv2['id'];
									$user_cmt_lv2 = $rowCmtLv2['ten_tv'];
									$created_cmt_lv2 = $rowCmtLv2['created_at'];
									$noidung_cmt_lv2 = $rowCmtLv2['noidung'];
								
							?>
							<div class="comment-item lv2">
								<div class="comment-item-avatar">
									<img src="img/icon/no-avt.png" alt="" width="100%" height="100%">
								</div>
								<div class="comment-item-content">
									<div class="name"><?php echo $user_cmt_lv2 ?></div>
									<div class="time"><?php echo $created_cmt_lv2 ?></div>
									<div class="content"><?php echo $noidung_cmt_lv2 ?></div>
									
								</div>
							</div>
							<?php } ?>
							<div class="check-cmt">
								<input type="text" placeholder="Nhập bình luận của bạn...">
								<button><i class="fa fa-paper-plane-o"></i></button>
							</div>
							<div class="comment-content lv2">
								<form action="" method="post">
									<input type="text" name="id_cmt" hidden readonly value="<?php echo $id_cmt ?>">
									<textarea name="post_cmt_noidung" class="rep-cmt" placeholder="Nhập bình luận của bạn..."></textarea>
									<button type="submit" name="rep_cmt" class="btn btn-primary"><i class="fa fa-paper-plane-o"></i>Gửi bình luận</button>
								</form>
							</div>
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
    var btnMoreContent = document.querySelector('.btn-more-content');
    var btnCollapseContent = document.querySelector('.btn-collapse-content');
    var content = document.querySelector('.description-content');
    if (content.scrollHeight <= 350) {
    	btnMoreContent.style.display = 'none';
    	btnCollapseContent.style.display = 'none';
    }
    btnMoreContent.addEventListener('click',moreContent);
    function moreContent(){
    	content.style.maxHeight = 'none';
    	btnMoreContent.style.display = 'none';
    	btnCollapseContent.style.display = 'block';
    }
    
    btnCollapseContent.addEventListener('click',collapseContent);
    function collapseContent(){
    	content.style.maxHeight = '350px';
    	btnMoreContent.style.display = 'block';
    	btnCollapseContent.style.display = 'none';
    	var backTo = setInterval(toContent,1);
    	function toContent(){
    		document.documentElement.scrollTop -= 10;
    		if (document.documentElement.scrollTop < content.offsetTop) {
    			clearInterval(backTo);
    		}
    	}
    }
    // 
	var commentItemContentsLv1 = document.querySelectorAll('.comment-item-content.lv1');
	var checkCmts = document.querySelectorAll('.check-cmt');
	var checkCmtInputs = document.querySelectorAll('.check-cmt input');
	var cmtContentsLv2 = document.querySelectorAll('.comment-content.lv2');
	var repCmts = document.querySelectorAll('.rep-cmt');

	checkCmtInputs.forEach(checkCmtInput);
	function checkCmtInput(element,index){
		element.addEventListener('click',function(){
			cmtContentsLv2[index].style.display = 'block';
			checkCmts[index].innerHTML = '';
			repCmts[index].focus();
		});
	}
</script>