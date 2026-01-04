<!-- Comment Form -->
<div id="respond" class="comment-respond bg-white">
	<h6 class="h7">Leave a Comment</h6>
	<div class="add-comment">
		<form action="submit_comment.php" method="post" id="commentform" class="comment-form">
			<input type="hidden" name="post_id" value="<?= $post['id'] ?>">
			<input name="name" type="text" value="" placeholder="Name*" required>
			<input name="email" type="email" value="" placeholder="Email*" required>
			<input name="url" type="url" value="" placeholder="Website" class="w-100">
			<textarea id="comment-reply" name="comment" rows="7" placeholder="Type Here Your Comment*" required></textarea>
			<button type="submit" class="lab-btn"><span>Send Comment</span></button>
		</form>
	</div>
</div>
