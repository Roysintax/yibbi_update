<?php
// Mengambil konfigurasi database yang sudah mendukung PDO
require_once 'admin/config/database.php';

// Konfigurasi Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; // Jumlah artikel per halaman
$offset = ($page - 1) * $limit;

// Query untuk mengambil artikel blog dengan pagination
try {
    // Menghitung total artikel untuk pagination
    $stmtCount = $pdo->query("SELECT COUNT(*) FROM blog_posts");
    $totalPosts = $stmtCount->fetchColumn();
    $totalPages = ceil($totalPosts / $limit);

    // Mengambil data artikel
    $stmt = $pdo->prepare("SELECT * FROM blog_posts ORDER BY published_at DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll();

    // Mengambil Kategori untuk Widget
    $stmtCategories = $pdo->query("SELECT * FROM blog_categories ORDER BY count DESC");
    $categories = $stmtCategories->fetchAll();

    // Mengambil Recent Posts untuk Widget
    $stmtRecent = $pdo->query("SELECT id, title, slug, image, published_at FROM blog_posts ORDER BY published_at DESC LIMIT 4");
    $recentPosts = $stmtRecent->fetchAll();

    // Mengambil Tags untuk Widget
    $stmtTags = $pdo->query("SELECT * FROM blog_tags");
    $tags = $stmtTags->fetchAll();

} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>
<!-- Include Header -->
<?php include 'includes/header.php'; ?>

    <!-- Page Header Section Start Here -->
    <!-- Awal bagian Judul Halaman (Page Header) -->
    <section class="page-header bg_img padding-tb">
        <div class="overlay"></div>
        <!-- Overlay gelap untuk background -->
        <div class="container">
            <div class="page-header-content-area">
                <h4 class="ph-title">Blog Page</h4>
                <!-- Judul Halaman -->
                <ul class="lab-ul">
                    <!-- Breadumb navigasi -->
                    <li><a href="index.html">Home</a></li>
                    <li><a class="active">Blog</a></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Page Header Section Ending Here -->
    <!-- Akhir bagian Judul Halaman -->

    <!-- Blog Section Start Here -->
    <!-- Awal bagian Konten Blog -->
    <div class="blog-section blog-page padding-tb aside-bg">
        <div class="container">
            <div class="section-wrapper">
                <div class="row justify-content-center">
                    <!-- Baris utama konten -->
                    <div class="col-lg-8 col-12">
                        <!-- Kolom kiri: Daftar Artikel Blog -->
                        <article>
                            <?php if (count($posts) > 0): ?>
                                <?php foreach ($posts as $post): ?>
                                    
                                    <!-- Logika Tampilan Berdasarkan Tipe Post -->
                                    
                                    <!-- Tipe 4: Quote (Kutipan) -->
                                    <?php if ($post['type'] == 'quote'): ?>
                                        <div class="post-item-2">
                                            <div class="post-inner">
                                                <div class="post-thumb">
                                                    <blockquote class="blog-quote text-center">
                                                        <!-- Isi Kutipan -->
                                                        <div class="quotes">
                                                            <?php echo htmlspecialchars($post['quote_text']); ?>
                                                        </div>
                                                    </blockquote>
                                                </div>
                                                <div class="post-content">
                                                    <a href="blog-single.php?slug=<?php echo $post['slug']; ?>">
                                                        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                                                    </a>
                                                    <ul class="lab-ul post-date">
                                                        <li><span><i class="icofont-ui-calendar"></i> <?php echo date('F j, Y g:i a', strtotime($post['published_at'])); ?></span></li>
                                                        <li><span><i class="icofont-user"></i><a href="#"><?php echo htmlspecialchars($post['author']); ?></a></span></li>
                                                        <li><span><i class="icofont-speech-comments"></i><a href="#"><?php echo str_pad($post['comment_count'], 2, '0', STR_PAD_LEFT); ?> Comments</a></span></li>
                                                    </ul>
                                                    <p><?php echo htmlspecialchars($post['excerpt']); ?></p>
                                                    <a href="blog-single.php?slug=<?php echo $post['slug']; ?>" class="lab-btn">Read More</a>
                                                </div>
                                            </div>
                                        </div>

                                    <!-- Tipe 3: Video -->
                                    <?php elseif ($post['type'] == 'video'): ?>
                                        <div class="post-item-2">
                                            <div class="post-inner">
                                                <div class="post-thumb">
                                                    <a href="blog-single.php?slug=<?php echo $post['slug']; ?>">
                                                        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="blog">
                                                    </a>
                                                    <!-- Tombol Play Video -->
                                                    <a href="<?php echo htmlspecialchars($post['video_url']); ?>" class="play-btn" data-rel="lightcase">
                                                        <i class="icofont-play"></i>
                                                        <span class="pluse_2"></span>
                                                    </a>
                                                </div>
                                                <div class="post-content">
                                                    <a href="blog-single.php?slug=<?php echo $post['slug']; ?>">
                                                        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                                                    </a>
                                                    <ul class="lab-ul post-date">
                                                        <li><span><i class="icofont-ui-calendar"></i> <?php echo date('F j, Y g:i a', strtotime($post['published_at'])); ?></span></li>
                                                        <li><span><i class="icofont-user"></i><a href="#"><?php echo htmlspecialchars($post['author']); ?></a></span></li>
                                                        <li><span><i class="icofont-speech-comments"></i><a href="#"><?php echo str_pad($post['comment_count'], 2, '0', STR_PAD_LEFT); ?> Comments</a></span></li>
                                                    </ul>
                                                    <p><?php echo htmlspecialchars($post['excerpt']); ?></p>
                                                    <a href="blog-single.php?slug=<?php echo $post['slug']; ?>" class="lab-btn">Read More</a>
                                                </div>
                                            </div>
                                        </div>

                                    <!-- Tipe 2: Slide (Standard + Slider logic can be complex, simplifying for now as standard image or handling multiple images if implemented) -->
                                    <!-- Untuk saat ini kita anggap slide mirip standard dulu atau jika ada array image -->
                                    <?php elseif ($post['type'] == 'slide'): ?>
                                        <!-- Placeholder logic untuk slide jika ada multiple images -->
                                        <div class="post-item-2">
                                            <div class="post-inner">
                                                <div class="post-thumb">
                                                    <a href="blog-single.php?slug=<?php echo $post['slug']; ?>">
                                                        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="blog">
                                                    </a>
                                                </div>
                                                <div class="post-content">
                                                    <a href="blog-single.php?slug=<?php echo $post['slug']; ?>">
                                                        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                                                    </a>
                                                    <ul class="lab-ul post-date">
                                                        <li><span><i class="icofont-ui-calendar"></i> <?php echo date('F j, Y g:i a', strtotime($post['published_at'])); ?></span></li>
                                                        <li><span><i class="icofont-user"></i><a href="#"><?php echo htmlspecialchars($post['author']); ?></a></span></li>
                                                        <li><span><i class="icofont-speech-comments"></i><a href="#"><?php echo str_pad($post['comment_count'], 2, '0', STR_PAD_LEFT); ?> Comments</a></span></li>
                                                    </ul>
                                                    <p><?php echo htmlspecialchars($post['excerpt']); ?></p>
                                                    <a href="blog-single.php?slug=<?php echo $post['slug']; ?>" class="lab-btn">Read More</a>
                                                </div>
                                            </div>
                                        </div>

                                    <!-- Tipe 1: Standard (Default) -->
                                    <?php else: ?>
                                        <div class="post-item-2">
                                            <div class="post-inner">
                                                <div class="post-thumb">
                                                    <!-- Thumbnail Gambar -->
                                                    <a href="blog-single.php?slug=<?php echo $post['slug']; ?>">
                                                        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="blog">
                                                    </a>
                                                </div>
                                                <div class="post-content">
                                                    <!-- Konten Artikel -->
                                                    <a href="blog-single.php?slug=<?php echo $post['slug']; ?>">
                                                        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                                                    </a>
                                                    <ul class="lab-ul post-date">
                                                        <!-- Meta data artikel -->
                                                        <li><span><i class="icofont-ui-calendar"></i> <?php echo date('F j, Y g:i a', strtotime($post['published_at'])); ?></span></li>
                                                        <li><span><i class="icofont-user"></i><a href="#"><?php echo htmlspecialchars($post['author']); ?></a></span></li>
                                                        <li><span><i class="icofont-speech-comments"></i><a href="#"><?php echo str_pad($post['comment_count'], 2, '0', STR_PAD_LEFT); ?> Comments</a></span></li>
                                                    </ul>
                                                    <!-- Ringkasan artikel -->
                                                    <p><?php echo htmlspecialchars($post['excerpt']); ?></p>
                                                    <!-- Tombol Baca Selengkapnya -->
                                                    <a href="blog-single.php?slug=<?php echo $post['slug']; ?>" class="lab-btn">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-info">Belum ada postingan blog.</div>
                            <?php endif; ?>


                            <!-- Pagination (Navigasi Halaman) -->
                            <?php if ($totalPages > 1): ?>
                            <div class="paginations">
                                <ul class="lab-ul d-flex flex-wrap justify-content-center mb-1">
                                    <?php if ($page > 1): ?>
                                    <li>
                                        <a href="?page=<?php echo $page - 1; ?>"><i class="icofont-rounded-double-left"></i></a>
                                    </li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li>
                                        <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                                    </li>
                                    <?php endfor; ?>

                                    <?php if ($page < $totalPages): ?>
                                    <li>
                                        <a href="?page=<?php echo $page + 1; ?>"><i class="icofont-rounded-double-right"></i></a>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                        </article>
                    </div>

                    <!-- Kolom Kanan: Sidebar Widget -->
                    <div class="col-lg-4 col-md-7 col-12">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog Section ENding Here -->
    <!-- Akhir bagian Konten Blog -->

    <!-- Footer Section start here -->
    <?php include 'includes/footer.php'; ?>
