<!-- Sidebar Widget -->
<aside class="ps-lg-4">
    <!-- Widget Search (Pencarian) -->
    <div class="widget widget-search">
        <div class="widget-header">
            <h5>Search Your keywords</h5>
        </div>
        <form action="blog.php" method="GET" class="search-wrapper">
            <input type="text" name="search" placeholder="Search Here..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit"><i class="icofont-search-2"></i></button>
        </form>
    </div>

    <!-- Widget Kategori -->
    <div class="widget widget-category">
        <div class="widget-header">
            <h5>Post Categories</h5>
        </div>
        <ul class="lab-ul widget-wrapper list-bg-none">
            <?php foreach ($categories as $cat): ?>
            <li>
                <a href="blog.php?category=<?php echo $cat['slug']; ?>" class="d-flex flex-wrap justify-content-between">
                    <span><i class="icofont-rounded-double-right"></i><?php echo htmlspecialchars($cat['name']); ?></span>
                    <span><?php echo $cat['count']; ?></span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Widget Postingan Terbaru -->
    <div class="widget widget-post">
        <div class="widget-header">
            <h5>Recent Post</h5>
        </div>
        <ul class="lab-ul widget-wrapper">
            <?php foreach ($recentPosts as $rPost): ?>
            <li class="d-flex flex-wrap justify-content-between">
                <div class="post-thumb">
                    <a href="blog-single.php?slug=<?php echo $rPost['slug']; ?>">
                        <img src="<?php echo htmlspecialchars($rPost['image']); ?>" alt="<?php echo htmlspecialchars($rPost['title']); ?>">
                    </a>
                </div>
                <div class="post-content ps-4">
                    <a href="blog-single.php?slug=<?php echo $rPost['slug']; ?>">
                        <h6><?php echo htmlspecialchars(substr($rPost['title'], 0, 40)) . (strlen($rPost['title']) > 40 ? '...' : ''); ?></h6>
                    </a>
                    <p><?php echo date('d F Y', strtotime($rPost['published_at'])); ?></p>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Widget Tag Populer -->
    <div class="widget widget-tags">
        <div class="widget-header">
            <h5>Our Popular tags</h5>
        </div>
        <ul class="lab-ul widget-wrapper">
            <?php foreach ($tags as $tag): ?>
            <li><a href="blog.php?tag=<?php echo $tag['slug']; ?>"><?php echo htmlspecialchars($tag['name']); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</aside>
