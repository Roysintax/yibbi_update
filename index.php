<?php
// ========================================
// Konfigurasi Database PDO
// ========================================
require_once 'config/database.php';

    // ========================================
    // Mengambil Data dari Database
    // ========================================

    // Note: Settings & Social Media diambil di dalam includes/header.php (atau bisa dipindah ke sini jika ingin lebih rapi)

    // Banners
    $stmt = $pdo->query("SELECT * FROM banners WHERE is_active = 1 ORDER BY order_index LIMIT 1");
    $banner = $stmt->fetch();

    // About Section (Now using About History)
    $stmt = $pdo->query("SELECT * FROM about_history LIMIT 1");
    $about = $stmt->fetch();

    // Features
    $stmt = $pdo->query("SELECT * FROM features WHERE is_active = 1 ORDER BY display_order ASC");
    $features = $stmt->fetchAll();

    // Services
    $stmt = $pdo->query("SELECT * FROM services WHERE is_active = 1 ORDER BY display_order ASC");
    $services = $stmt->fetchAll();

    // Programs (only regular type for slider)
    $stmt = $pdo->query("SELECT * FROM programs WHERE type = 'regular'");
    $programs = $stmt->fetchAll();
    
    // Calculate percentage for each program
    foreach ($programs as &$program) {
        if ($program['target_amount'] > 0) {
            $program['percentage'] = round(($program['amount_raised'] / $program['target_amount']) * 100);
        } else {
            $program['percentage'] = 0;
        }
    }
    unset($program); // Break reference


    // Faiths (Rukun Islam)
    $stmt = $pdo->query("SELECT * FROM faiths ORDER BY order_index");
    $faiths = $stmt->fetchAll();

    // Quotes
    $stmt = $pdo->query("SELECT * FROM quotes ORDER BY RAND() LIMIT 1");
    $quote = $stmt->fetch();

    // Events
    $stmt = $pdo->query("SELECT * FROM events ORDER BY id DESC LIMIT 4");
    $events = $stmt->fetchAll();



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
