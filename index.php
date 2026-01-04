<?php
// ========================================
// Konfigurasi Database PDO
// ========================================
$host = 'localhost';
$dbname = 'yibbi_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // ========================================
    // Mengambil Data dari Database
    // ========================================

    // Note: Settings & Social Media diambil di dalam includes/header.php (atau bisa dipindah ke sini jika ingin lebih rapi)

    // Banners
    $stmt = $pdo->query("SELECT * FROM banners WHERE is_active = 1 ORDER BY order_index LIMIT 1");
    $banner = $stmt->fetch();

    // About Section
    $stmt = $pdo->query("SELECT * FROM about_section LIMIT 1");
    $about = $stmt->fetch();

    // Features
    $stmt = $pdo->query("SELECT * FROM features ORDER BY order_index");
    $features = $stmt->fetchAll();

    // Services
    $stmt = $pdo->query("SELECT * FROM services");
    $services = $stmt->fetchAll();

    // Programs (only regular type for slider)
    $stmt = $pdo->query("SELECT * FROM programs WHERE type = 'regular'");
    $programs = $stmt->fetchAll();

    // Faiths (Rukun Islam)
    $stmt = $pdo->query("SELECT * FROM faiths ORDER BY order_index");
    $faiths = $stmt->fetchAll();

    // Quotes
    $stmt = $pdo->query("SELECT * FROM quotes ORDER BY RAND() LIMIT 1");
    $quote = $stmt->fetch();

    // Events
    $stmt = $pdo->query("SELECT * FROM events ORDER BY id DESC LIMIT 4");
    $events = $stmt->fetchAll();

} catch (PDOException $e) {
    // Jika terjadi error (koneksi atau query), arahkan ke 404.php
    http_response_code(404); // Set response code 404
    include '404.php';
    exit;
}
?>

<!-- Include Header -->
<?php include 'includes/header.php'; ?>

<!-- Include Banner Section -->
<?php include 'includes/home/banner.php'; ?>

<!-- Include About Section -->
<?php include 'includes/home/about.php'; ?>

<!-- Include Feature Section -->
<?php include 'includes/home/feature.php'; ?>

<!-- Include Service Section -->
<?php include 'includes/home/service.php'; ?>

<!-- Include Urgent Campaign Section -->
<?php include 'includes/home/urgent_campaign.php'; ?>

<!-- Include Upcoming Programs Section -->
<?php include 'includes/home/programs.php'; ?>

<!-- Include Faith Section -->
<?php include 'includes/home/faith.php'; ?>

<!-- Include Quote Section -->
<?php include 'includes/home/quote.php'; ?>

<!-- Include Event Section -->
<?php include 'includes/home/event.php'; ?>

<!-- Include Footer -->
<?php include 'includes/footer.php'; ?>
