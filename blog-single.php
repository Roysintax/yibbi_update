<?php
// ========================================
// Konfigurasi Database PDO & Settings
// ========================================
require_once 'admin/config/database.php';

// Settings (untuk informasi header & footer)
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch();

// Social Media
$stmt = $pdo->query("SELECT * FROM social_media WHERE is_active = 1 ORDER BY order_index");
$socialMedia = $stmt->fetchAll();

// ========================================
// Ambil Slug dari URL Parameter
// ========================================
// Contoh: blog-single.php?slug=continually-proactive-services
$slug = $_GET['slug'] ?? 'continually-proactive-services'; // Default slug jika tidak ada parameter

// ========================================
// Query Blog Post dengan Author Info
// ========================================
// Menggunakan JOIN untuk mendapatkan data post + author sekaligus
$stmt = $pdo->prepare("
    SELECT 
        p.id, p.title, p.slug, p.image, p.content, p.excerpt, 
        p.published_at, p.comment_count, p.type, p.video_url, p.quote_text,
        a.name AS author_name, a.slug AS author_slug, a.email AS author_email,
        a.avatar AS author_avatar, a.bio AS author_bio,
        a.twitter, a.behance, a.instagram, a.vimeo, a.linkedin
    FROM blog_posts p
    LEFT JOIN blog_authors a ON p.author_id = a.id
    WHERE p.slug = :slug
    LIMIT 1
");
$stmt->execute(['slug' => $slug]);
$post = $stmt->fetch();

// Jika post tidak ditemukan, redirect ke 404
if (!$post) {
    header('Location: 404.php');
    exit;
}

// ========================================
// Query Comments untuk Post ini
// ========================================
$stmt = $pdo->prepare("
    SELECT * FROM blog_comments
    WHERE post_id = :post_id AND status = 'approved' AND parent_id IS NULL
    ORDER BY created_at ASC
");
$stmt->execute(['post_id' => $post['id']]);
$comments = $stmt->fetchAll();

// Function untuk mendapatkan replies dari comment
function getCommentReplies($pdo, $comment_id, $post_id) {
    $stmt = $pdo->prepare("
        SELECT * FROM blog_comments
        WHERE post_id = :post_id AND parent_id = :parent_id AND status = 'approved'
        ORDER BY created_at ASC
    ");
    $stmt->execute(['post_id' => $post_id, 'parent_id' => $comment_id]);
    return $stmt->fetchAll();
}

// ========================================
// Query Tags untuk Post ini
// ========================================
$stmt = $pdo->prepare("
    SELECT t.* FROM blog_tags t
    INNER JOIN blog_post_tags pt ON t.id = pt.tag_id
    WHERE pt.post_id = :post_id
");
$stmt->execute(['post_id' => $post['id']]);
$post_tags = $stmt->fetchAll();

// ========================================
// Query Data untuk Sidebar Widgets
// ========================================

// Recent Posts (4 posts terbaru, exclude post yang sedang dibuka)
$stmt = $pdo->prepare("
    SELECT id, title, slug, image, published_at 
    FROM blog_posts 
    WHERE id != :current_post_id
    ORDER BY published_at DESC 
    LIMIT 4
");
$stmt->execute(['current_post_id' => $post['id']]);
$recent_posts = $stmt->fetchAll();

// Categories
$stmt = $pdo->query("SELECT * FROM blog_categories ORDER BY name ASC");
$categories = $stmt->fetchAll();

// Popular Tags
$stmt = $pdo->query("SELECT * FROM blog_tags ORDER BY name ASC LIMIT 9");
$tags = $stmt->fetchAll();

// ========================================
// Query untuk Previous & Next Post Navigation
// ========================================
// Previous Post (post sebelumnya berdasarkan tanggal publish)
$stmt = $pdo->prepare("
    SELECT id, title, slug, excerpt 
    FROM blog_posts 
    WHERE published_at < :current_date
    ORDER BY published_at DESC 
    LIMIT 1
");
$stmt->execute(['current_date' => $post['published_at']]);
$prev_post = $stmt->fetch();

// Next Post (post berikutnya berdasarkan tanggal publish)
$stmt = $pdo->prepare("
    SELECT id, title, slug, excerpt 
    FROM blog_posts 
    WHERE published_at > :current_date
    ORDER BY published_at ASC 
    LIMIT 1
");
$stmt->execute(['current_date' => $post['published_at']]);
$next_post = $stmt->fetch();

?>
<?php include 'includes/header.php'; ?>

	<!-- Page Header Section Start Here -->
	<section class="page-header bg_img padding-tb">
		<div class="overlay"></div>
		<div class="container">
			<div class="page-header-content-area">
				<h4 class="ph-title"><?= htmlspecialchars($post['title']) ?></h4>
				<ul class="lab-ul">
					<li><a href="index.php">Home</a></li>
					<li><a href="blog.php">Blog</a></li>
					<li><a class="active"><?= htmlspecialchars($post['title']) ?></a></li>
				</ul>
			</div>
		</div>
	</section>
	<!-- Page Header Section Ending Here -->

	<!-- Blog Section Start Here -->
	<div class="blog-section blog-page padding-tb aside-bg">
		<div class="container">
			<div class="section-wrapper">
				<div class="row justify-content-center pb-15">
					<div class="col-lg-8 col-12">
						<article>
							<?php include 'includes/blog-single/article-content.php'; ?>
							
							<?php include 'includes/blog-single/navigation.php'; ?>
							
							<?php include 'includes/blog-single/author-box.php'; ?>

							<?php include 'includes/blog-single/comments.php'; ?>

							<?php include 'includes/blog-single/comment-form.php'; ?>
						</article>
					</div>
					
					<!-- Sidebar -->
					<div class="col-lg-4 col-md-7 col-12">
						<?php include 'includes/blog-single/sidebar.php'; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Blog Section ENding Here -->

<?php include 'includes/footer.php'; ?>