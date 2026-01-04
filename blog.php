<?php
// ========================================
// Konfigurasi Database PDO
// ========================================
require_once 'config/database.php';

// Settings (untuk informasi header & footer)
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch();

// Social Media
$stmt = $pdo->query("SELECT * FROM social_media WHERE is_active = 1 ORDER BY order_index");
$socialMedia = $stmt->fetchAll();

// ========================================
// Konfigurasi Pagination
// ========================================
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; // Jumlah artikel per halaman
$offset = ($page - 1) * $limit;

// ========================================
// Query untuk Blog Posts dengan Filter
// ========================================
try {
    // Base query
    $whereClause = "WHERE 1=1";
    $params = [];
    
    // Filter Search
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $whereClause .= " AND (title LIKE :search OR excerpt LIKE :search OR content LIKE :search)";
        $params['search'] = '%' . $_GET['search'] . '%';
    }
    
    // Filter Category
    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $whereClause .= " AND id IN (
            SELECT post_id FROM blog_post_categories 
            WHERE category_id = (SELECT id FROM blog_categories WHERE slug = :category)
        )";
        $params['category'] = $_GET['category'];
    }
    
    // Filter Tag
    if (isset($_GET['tag']) && !empty($_GET['tag'])) {
        $whereClause .= " AND id IN (
            SELECT post_id FROM blog_post_tags 
            WHERE tag_id = (SELECT id FROM blog_tags WHERE slug = :tag)
        )";
        $params['tag'] = $_GET['tag'];
    }
    
    // Menghitung total artikel untuk pagination
    $stmtCount = $pdo->prepare("SELECT COUNT(*) FROM blog_posts $whereClause");
    $stmtCount->execute($params);
    $totalPosts = $stmtCount->fetchColumn();
    $totalPages = ceil($totalPosts / $limit);
    
    // Mengambil data artikel dengan pagination
    $stmt = $pdo->prepare("
        SELECT * FROM blog_posts 
        $whereClause 
        ORDER BY published_at DESC 
        LIMIT :limit OFFSET :offset
    ");
    
    // Bind parameters
    foreach ($params as $key => $value) {
        $stmt->bindValue(':' . $key, $value);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
    $stmt->execute();
    $posts = $stmt->fetchAll();
    
    // ========================================
    // Query Data untuk Sidebar Widgets
    // ========================================
    
    // Mengambil Kategori untuk Widget
    $stmtCategories = $pdo->query("SELECT * FROM blog_categories ORDER BY count DESC");
    $categories = $stmtCategories->fetchAll();
    
    // Mengambil Recent Posts untuk Widget
    $stmtRecent = $pdo->query("SELECT id, title, slug, image, published_at FROM blog_posts ORDER BY published_at DESC LIMIT 4");
    $recentPosts = $stmtRecent->fetchAll();
    
    // Mengambil Tags untuk Widget
    $stmtTags = $pdo->query("SELECT * FROM blog_tags ORDER BY name ASC");
    $tags = $stmtTags->fetchAll();
    
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>
<!-- Include Header -->
<?php include 'includes/header.php'; ?>

    <!-- Page Header Section Start Here -->
    <section class="page-header bg_img padding-tb">
        <div class="overlay"></div>
        <div class="container">
            <div class="page-header-content-area">
                <h4 class="ph-title">Blog Page</h4>
                <ul class="lab-ul">
                    <li><a href="assets/x.php">Home</a></li>
                    <li><a class="active">Blog</a></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Page Header Section Ending Here -->

    <!-- Blog Section Start Here -->
    <div class="blog-section blog-page padding-tb aside-bg">
        <div class="container">
            <div class="section-wrapper">
                <div class="row justify-content-center">
                    <!-- Kolom Kiri: Daftar Artikel Blog -->
                    <div class="col-lg-8 col-12">
                        <article>
                            <?php include 'includes/blog/post-list.php'; ?>
                            
                            <?php include 'includes/blog/pagination.php'; ?>
                        </article>
                    </div>

                    <!-- Kolom Kanan: Sidebar Widget -->
                    <div class="col-lg-4 col-md-7 col-12">
                        <?php include 'includes/blog/sidebar.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog Section ENding Here -->

    <!-- Footer Section start here -->
    <?php include 'includes/footer.php'; ?>
