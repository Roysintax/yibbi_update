<?php
require_once 'config/database.php';
require_once 'includes/header.php';

// Fetch scholars data
try {
    $stmt = $pdo->query("SELECT * FROM scholars WHERE is_active = 1 ORDER BY display_order ASC");
    $scholars = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $scholars = [];
    // Log error silently
    error_log("Error fetching scholars: " . $e->getMessage());
}
?>

    <!-- Page Header Section Start Here -->
    <section class="page-header bg_img padding-tb">
        <div class="overlay"></div>
        <div class="container">
            <div class="page-header-content-area">
                <h4 class="ph-title">Our Quran Scholor</h4>
                <ul class="lab-ul">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="index.php">Features</a></li>
                    <li><a class="active">Scholars</a></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Page Header Section Ending Here -->

    <!-- Team section start here -->
    <div class="team-section padding-tb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row justify-content-center">
                        <?php if ($scholars): ?>
                            <?php foreach ($scholars as $scholar): ?>
                            <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                                <div class="card mb-4 text-center border-none team-item-1 pattern-2">
                                    <div class="lab-inner">
                                        <div class="lab-thumb">
                                            <img src="<?php echo htmlspecialchars($scholar['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($scholar['name']); ?>">
                                        </div>
                                        <div class="lab-content">
                                            <a href="scholar-single.php?id=<?php echo $scholar['id']; ?>">
                                                <h6 class="card-title mb-0"><?php echo htmlspecialchars($scholar['name']); ?></h6>
                                            </a>
                                            <p class="card-text mb-3"><?php echo htmlspecialchars($scholar['title']); ?></p>
                                            <div class="social-share">
                                                <a href="<?php echo htmlspecialchars($scholar['social_twitter'] ?? '#'); ?>" class="m-1 twitter"><i class="icofont-twitter"></i></a>
                                                <a href="<?php echo htmlspecialchars($scholar['social_behance'] ?? '#'); ?>" class="m-1 behance"><i class="icofont-behance"></i></a>
                                                <a href="<?php echo htmlspecialchars($scholar['social_instagram'] ?? '#'); ?>" class="m-1 instagram"><i class="icofont-instagram"></i></a>
                                                <a href="<?php echo htmlspecialchars($scholar['social_vimeo'] ?? '#'); ?>" class="m-1 vimeo"><i class="icofont-vimeo"></i></a>
                                                <a href="<?php echo htmlspecialchars($scholar['social_linkedin'] ?? '#'); ?>" class="m-1 linkedin"><i class="icofont-linkedin"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center">
                                <p>No scholars found.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team section end here -->

<?php require_once 'includes/footer.php'; ?>
