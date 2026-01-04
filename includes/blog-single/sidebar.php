<!-- Sidebar -->
<aside class="ps-lg-4 mt-5 mt-lg-0 pt-1 pt-lg-0">
	<!-- Search Widget -->
	<div class="widget widget-search">
		<div class="widget-header">
			<h5>Search Your keywords</h5>
		</div>
		<form action="blog.php" method="get" class="search-wrapper">
			<input type="text" name="s" placeholder="Search Here...">
			<button type="submit"><i class="icofont-search-2"></i></button>
		</form>
	</div>

	<!-- Categories Widget -->
	<div class="widget widget-category">
		<div class="widget-header">
			<h5>Post Categories</h5>
		</div>
		<ul class="lab-ul widget-wrapper list-bg-none">
			<li>
				<a href="blog.php" class="d-flex flex-wrap justify-content-between">
					<span><i class="icofont-rounded-double-right"></i>Show all</span>
					<span><?= array_sum(array_column($categories, 'count')) ?></span>
				</a>
			</li>
			<?php foreach ($categories as $category): ?>
			<li>
				<a href="blog.php?category=<?= urlencode($category['slug']) ?>" class="d-flex flex-wrap justify-content-between">
					<span><i class="icofont-rounded-double-right"></i><?= htmlspecialchars($category['name']) ?></span>
					<span><?= $category['count'] ?></span>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>

	<!-- Recent Posts Widget -->
	<div class="widget widget-post">
		<div class="widget-header">
			<h5>Recent Post</h5>
		</div>
		<ul class="lab-ul widget-wrapper">
			<?php foreach ($recent_posts as $recent): ?>
			<li class="d-flex flex-wrap justify-content-between">
				<div class="post-thumb">
					<a href="blog-single.php?slug=<?= urlencode($recent['slug']) ?>">
						<img src="<?= htmlspecialchars($recent['image']) ?>" alt="<?= htmlspecialchars($recent['title']) ?>">
					</a>
				</div>
				<div class="post-content ps-4">
					<a href="blog-single.php?slug=<?= urlencode($recent['slug']) ?>">
						<h6><?= htmlspecialchars($recent['title']) ?></h6>
					</a>
					<p><?= date('d F Y', strtotime($recent['published_at'])) ?></p>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>

	<!-- Instagram Widget (Static) -->
	<div class="widget widget-instagram">
		<div class="widget-header">
			<h5>Instagram</h5>
		</div>
		<ul class="lab-ul widget-wrapper d-flex flex-wrap justify-content-center">
			<li><a href="#"><img src="assets/images/gallery/01.jpg" alt="gallery-img"></a></li>
			<li><a href="#"><img src="assets/images/gallery/02.jpg" alt="gallery-img"></a></li>
			<li><a href="#"><img src="assets/images/gallery/03.jpg" alt="gallery-img"></a></li>
			<li><a href="#"><img src="assets/images/gallery/04.jpg" alt="gallery-img"></a></li>
			<li><a href="#"><img src="assets/images/gallery/05.jpg" alt="gallery-img"></a></li>
			<li><a href="#"><img src="assets/images/gallery/06.jpg" alt="gallery-img"></a></li>
			<li><a href="#"><img src="assets/images/gallery/07.jpg" alt="gallery-img"></a></li>
			<li><a href="#"><img src="assets/images/gallery/08.jpg" alt="gallery-img"></a></li>
			<li><a href="#"><img src="assets/images/gallery/09.jpg" alt="gallery-img"></a></li>
		</ul>
	</div>

	<!-- Archive Widget (Static - bisa dibuat dynamic nanti) -->
	<div class="widget widget-archive">
		<div class="widget-header">
			<h5>Our Archive</h5>
		</div>
		<ul class="lab-ul widget-wrapper list-bg-none">
			<li><a href="#" class="d-flex flex-wrap justify-content-between"><span><i class="icofont-ui-calendar"></i>January</span><span>2021</span></a></li>
			<li><a href="#" class="d-flex flex-wrap justify-content-between"><span><i class="icofont-ui-calendar"></i>February</span><span>2021</span></a></li>
			<li><a href="#" class="d-flex flex-wrap justify-content-between"><span><i class="icofont-ui-calendar"></i>March</span><span>2019</span></a></li>
			<li><a href="#" class="d-flex flex-wrap justify-content-between"><span><i class="icofont-ui-calendar"></i>August</span><span>2018</span></a></li>
			<li><a href="#" class="d-flex flex-wrap justify-content-between"><span><i class="icofont-ui-calendar"></i>September</span><span>2017</span></a></li>
			<li><a href="#" class="d-flex flex-wrap justify-content-between"><span><i class="icofont-ui-calendar"></i>October</span><span>2016</span></a></li>
			<li><a href="#" class="d-flex flex-wrap justify-content-between"><span><i class="icofont-ui-calendar"></i>November</span><span>2014</span></a></li>
			<li><a href="#" class="d-flex flex-wrap justify-content-between"><span><i class="icofont-ui-calendar"></i>December</span><span>2013</span></a></li>
		</ul>
	</div>

	<!-- Tags Widget -->
	<div class="widget widget-tags">
		<div class="widget-header">
			<h5>Our Popular tags</h5>
		</div>
		<ul class="lab-ul widget-wrapper">
			<?php foreach ($tags as $tag): ?>
			<li><a href="blog.php?tag=<?= urlencode($tag['slug']) ?>"><?= htmlspecialchars($tag['name']) ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</aside>
