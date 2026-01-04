<!-- Article Pagination (Previous/Next) -->
<div class="article-pagination">
	<?php if ($prev_post): ?>
	<div class="prev-article">
		<a href="blog-single.php?slug=<?= urlencode($prev_post['slug']) ?>">
			<i class="icofont-rounded-double-left"></i>Previous Article
		</a>
		<p><?= htmlspecialchars($prev_post['excerpt']) ?></p>
	</div>
	<?php endif; ?>
	
	<?php if ($next_post): ?>
	<div class="next-article">
		<a href="blog-single.php?slug=<?= urlencode($next_post['slug']) ?>">
			Next Article <i class="icofont-rounded-double-right"></i>
		</a>
		<p><?= htmlspecialchars($next_post['excerpt']) ?></p>
	</div>
	<?php endif; ?>
</div>
