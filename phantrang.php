<div class="pagination">
	<ul>
		<?php if($page > 1): ?>
		<li>
			<a href="<?php echo isset($param)  ? '?'.$param.'&' : '?' ?>page=<?php echo $page - 1 ?>">&#60</a>
		</li>
		<?php endif; ?>
		<?php for ($i=1; $i <= $totalPage ; $i++) :?>
		<li class="<?php echo isset($page) && $page == $i ? 'active' : '' ?>">
			<a href="<?php echo isset($param)  ? '?'.$param.'&' : '?' ?>page=<?php echo $i; ?>"><?php echo $i; ?></a>
		</li>
		<?php endfor; ?>
		<?php if($page < $totalPage): ?>
		<li>
			<a href="<?php echo isset($param)  ? '?'.$param.'&' : '?' ?>page=<?php echo $page + 1 ?>">&#62</a>
		</li>
		<?php endif; ?>
	</ul>
</div>