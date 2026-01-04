<?php
// ========================================
// Konfigurasi Database PDO & Settings
// ========================================
require_once 'config/database.php';

// Settings (untuk informasi header & footer)
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch();

// Social Media
$stmt = $pdo->query("SELECT * FROM social_media WHERE is_active = 1 ORDER BY order_index");
$socialMedia = $stmt->fetchAll();

// Contact Settings
$stmt = $pdo->query("SELECT * FROM contact_settings LIMIT 1");
$contactSettings = $stmt->fetch();

// Contact Info Cards
$stmt = $pdo->query("SELECT * FROM contact_info ORDER BY order_index");
$contactInfo = $stmt->fetchAll();
?>
<!-- Include Header -->
<?php include 'includes/header.php'; ?>

    <!-- Page Header Section Start Here -->
    <section class="page-header bg_img padding-tb">
        <div class="overlay"></div>
        <div class="container">
            <div class="page-header-content-area">
                <h4 class="ph-title"><?php echo htmlspecialchars($contactSettings['header_title'] ?? 'Contact us via mail'); ?></h4>
                <ul class="lab-ul">
                    <li><a href="index.php">Home</a></li>
                    <li><a class="active">Contact us</a></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Page Header Section Ending Here -->

    <!-- Contact Us Section Start Here -->  
    <div class="contact-section">
        <div class="contact-top padding-tb aside-bg padding-b">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <?php include 'includes/contact/contact-form.php'; ?>
                    </div>
                    <div class="col-lg-4">
                        <?php include 'includes/contact/contact-info.php'; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include 'includes/contact/contact-map.php'; ?>
    </div>
    <!-- Contact Us Section ENding Here -->

    <!-- Footer Section start here -->
    <?php include 'includes/footer.php'; ?>