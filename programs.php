<?php
// ========================================
// Konfigurasi Database PDO
// ========================================
require_once 'config/database.php';

// ========================================
// Mengambil Data dari Database
// ========================================

// Settings (untuk header & footer)
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch();

// Social Media
$stmt = $pdo->query("SELECT * FROM social_media WHERE is_active = 1 ORDER BY order_index");
$socialMedia = $stmt->fetchAll();

// Programs
$stmt = $pdo->query("SELECT * FROM programs WHERE is_active = 1 ORDER BY id DESC");
$programs = $stmt->fetchAll();

// Calculate percentage for each program
foreach ($programs as &$program) {
    if ($program['target_amount'] > 0) {
        $program['percentage'] = round(($program['amount_raised'] / $program['target_amount']) * 100);
    } else {
        $program['percentage'] = 0;
    }
}
unset($program);
?>

<!-- Include Header -->
<?php include 'includes/header.php'; ?>

    <!-- Page Header Section Start Here -->
    <section class="page-header bg_img padding-tb">
        <div class="overlay"></div>
        <div class="container">
            <div class="page-header-content-area">
                <h4 class="ph-title">Our Popular Program</h4>
                <ul class="lab-ul">
                    <li><a href="index.php">Home</a></li>
                    <li><a class="active">Program</a></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Page Header Section Ending Here -->

    <!-- Program section start Here -->
    <div class="program-section padding-tb padding-b">
        <div class="container">
            <div class="row justify-content-center">
                <?php if (count($programs) > 0): ?>
                    <?php foreach ($programs as $index => $program): ?>
                    <!-- Item Program -->
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="program-item <?php echo ($index < count($programs) - 3) ? 'mb-4' : (($index >= count($programs) - 3 && $index < count($programs) - 1) ? 'mb-4 mb-xl-0' : ''); ?>">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <a href="#">
                                        <img src="<?php echo htmlspecialchars($program['image']); ?>" alt="program-image">
                                    </a>
                                    <!-- Info Progress Donasi -->
                                    <div class="lab-thumb-content">
                                        <div class="progress-item">
                                            <ul class="progress-item-status lab-ul d-flex justify-content-between mb-2">
                                                <li>Raised<span> $<?php echo number_format($program['amount_raised'], 0); ?></span></li>
                                                <li>Goal<span> $<?php echo number_format($program['target_amount'], 0); ?></span></li>
                                            </ul>
                                            <div class="progress-bar-wrapper progress" data-percent="<?php echo $program['percentage']; ?>%">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated">
                                                </div>
                                            </div>
                                            <div class="progress-bar-percent d-flex align-items-center justify-content-center">
                                                <?php echo $program['percentage']; ?> <sup>%</sup>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Detail Konten Program -->
                                <div class="lab-content">
                                    <span><?php echo htmlspecialchars($program['category'] ?? 'Program'); ?></span>
                                    <h5><a href="#"><?php echo htmlspecialchars($program['title']); ?></a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p>Belum ada program yang tersedia.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Program section end Here -->

<!-- Include Footer -->
<?php include 'includes/footer.php'; ?>