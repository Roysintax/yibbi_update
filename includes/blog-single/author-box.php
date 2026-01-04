<!-- Author Box -->
<?php if ($post['author_name']): ?>
<div class="authors">
	<div class="author-thumb">
		<img src="<?= htmlspecialchars($post['author_avatar']) ?>" alt="<?= htmlspecialchars($post['author_name']) ?>">
	</div>
	<div class="author-content">
		<h6><?= htmlspecialchars($post['author_name']) ?></h6>
		<p><?= htmlspecialchars($post['author_bio']) ?></p>
		<div class="social-media">
			<?php if ($post['twitter']): ?>
			<a href="https://twitter.com/<?= htmlspecialchars($post['twitter']) ?>" class="twitter" target="_blank"><i class="icofont-twitter"></i></a>
			<?php endif; ?>
			<?php if ($post['behance']): ?>
			<a href="https://behance.net/<?= htmlspecialchars($post['behance']) ?>" class="behance" target="_blank"><i class="icofont-behance"></i></a>
			<?php endif; ?>
			<?php if ($post['instagram']): ?>
			<a href="https://instagram.com/<?= htmlspecialchars($post['instagram']) ?>" class="instagram" target="_blank"><i class="icofont-instagram"></i></a>
			<?php endif; ?>
			<?php if ($post['vimeo']): ?>
			<a href="https://vimeo.com/<?= htmlspecialchars($post['vimeo']) ?>" class="vimeo" target="_blank"><i class="icofont-vimeo"></i></a>
			<?php endif; ?>
			<?php if ($post['linkedin']): ?>
			<a href="https://linkedin.com/in/<?= htmlspecialchars($post['linkedin']) ?>" class="linkedin" target="_blank"><i class="icofont-linkedin"></i></a>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>
