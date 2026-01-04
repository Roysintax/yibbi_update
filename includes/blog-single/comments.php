<!-- Comments Section -->
<div id="comments" class="comments bg-white">
	<h6 class="comment-title h7"><?= sprintf('%02d', count($comments)) ?> Comment<?= count($comments) != 1 ? 's' : '' ?></h6>
	
	<?php if (count($comments) > 0): ?>
	<ul class="lab-ul comment-list">
		<?php foreach ($comments as $comment): ?>
		<li class="comment" id="comment-<?= $comment['id'] ?>">
			<div class="com-item">
				<div class="com-thumb">
					<img alt="<?= htmlspecialchars($comment['author_name']) ?>" 
						 src="<?= htmlspecialchars($comment['author_avatar']) ?>" 
						 class="avatar avatar-90 photo" height="90" width="90">
				</div>
				<div class="com-content">
					<div class="com-title">
						<div class="com-title-meta">
							<a href="<?= $comment['author_website'] ? htmlspecialchars($comment['author_website']) : '#' ?>" 
							   rel="external nofollow" class="h7">
								<?= htmlspecialchars($comment['author_name']) ?>
							</a>
							<span><?= date('F d, Y \a\t g:i a', strtotime($comment['created_at'])) ?></span>
						</div>
						<span class="reply">
							<a rel="nofollow" class="comment-reply-link" href="#respond">
								<i class="icofont-reply-all"></i>Reply
							</a>
						</span>
					</div>
					<p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
				</div>
			</div>
			
			<!-- Nested Replies -->
			<?php 
			$replies = getCommentReplies($pdo, $comment['id'], $post['id']);
			if (count($replies) > 0): 
			?>
			<ul class="lab-ul comment-list">
				<?php foreach ($replies as $reply): ?>
				<li class="comment" id="comment-<?= $reply['id'] ?>">
					<div class="com-thumb">
						<img alt="<?= htmlspecialchars($reply['author_name']) ?>" 
							 src="<?= htmlspecialchars($reply['author_avatar']) ?>" 
							 class="avatar avatar-90 photo" height="90" width="90">
					</div>
					<div class="com-content">
						<div class="com-title">
							<div class="com-title-meta">
								<a href="<?= $reply['author_website'] ? htmlspecialchars($reply['author_website']) : '#' ?>" 
								   rel="external nofollow" class="h7">
									<?= htmlspecialchars($reply['author_name']) ?>
								</a>
								<span><?= date('F d, Y \a\t g:i a', strtotime($reply['created_at'])) ?></span>
							</div>
							<span class="reply">
								<a rel="nofollow" class="comment-reply-link" href="#respond">
									<i class="icofont-reply-all"></i>Reply
								</a>
							</span>
						</div>
						<p><?= nl2br(htmlspecialchars($reply['content'])) ?></p>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
</div>
