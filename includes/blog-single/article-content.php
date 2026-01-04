<!-- Article Content Section -->
<div class="post-item-2">
	<div class="post-inner">
		<?php if ($post['image']): ?>
		<div class="post-thumb">
			<img src="<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
		</div>
		<?php endif; ?>
		
		<div class="post-content">
			<h3><?= htmlspecialchars($post['title']) ?></h3>
			<ul class="lab-ul post-date">
				<li><span><i class="icofont-ui-calendar"></i> <?= date('F d, Y g:i a', strtotime($post['published_at'])) ?></span></li>
				<li><span><i class="icofont-user"></i><a href="#"><?= htmlspecialchars($post['author_name']) ?></a></span></li>
				<li><span><i class="icofont-speech-comments"></i><a href="#comments"><?= $post['comment_count'] ?> Comments</a></span></li>
			</ul>
			
			<!-- Content Post -->
			<div class="post-full-content">
				<?= $post['content'] ?>
			</div>

			<!-- Tags & Share -->
			<div class="tags-area">
				<ul class="tags lab-ul justify-content-center">
					<?php foreach ($post_tags as $tag): ?>
					<li><a href="blog.php?tag=<?= urlencode($tag['slug']) ?>"><?= htmlspecialchars($tag['name']) ?></a></li>
					<?php endforeach; ?>
				</ul>
				<ul class="share lab-ul justify-content-center">
					<li><a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a></li>
					<li><a href="#" class="dribble"><i class="fab fa-dribbble"></i></a></li>
					<li><a href="#" class="twitter"><i class="fab fa-twitter"></i></a></li>
					<li><a href="#" class="google"><i class="fab fa-google-plus-g"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
