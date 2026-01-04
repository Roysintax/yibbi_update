<?php
require_once 'config/database.php';
require_once 'includes/header.php';

// Get scholar ID from URL
$scholar_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch scholar data
$scholar = null;
if ($scholar_id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM scholars WHERE id = ? AND is_active = 1");
        $stmt->execute([$scholar_id]);
        $scholar = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching scholar: " . $e->getMessage());
    }
}

// If scholar not found, redirect to scholars page
if (!$scholar) {
    header("Location: scholar.php");
    exit;
}

// Decode JSON fields
$language_skills = json_decode($scholar['language_skills'] ?? '[]', true) ?: [];
$awards = json_decode($scholar['awards'] ?? '[]', true) ?: [];
?>

    <!-- Page Header Section Start Here -->
    <section class="page-header bg_img padding-tb">
        <div class="overlay"></div>
        <div class="container">
            <div class="page-header-content-area">
                <h4 class="ph-title"><?php echo htmlspecialchars($scholar['name']); ?></h4>
                <ul class="lab-ul">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="scholar.php">Scholars</a></li>
                    <li><a class="active">Scholar Single</a></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Page Header Section Ending Here -->

    <!-- Scholar single section start Here -->
    <div class="scholar-single-section padding-tb padding-b">
        <div class="container">
            <div class="section-wrapper bg-white pattern-3">
                <div class="section-inner">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="scholar-left">
                                <div class="scholar-single-item">
                                    <div class="scholar-single-thumb">
                                        <img src="<?php echo htmlspecialchars($scholar['detail_image'] ?? $scholar['image']); ?>" alt="<?php echo htmlspecialchars($scholar['name']); ?>" />
                                    </div>
                                    <?php if (!empty($language_skills)): ?>
                                    <div class="scholar-single-content">
                                        <span class="h7">Personal Language Skill</span>
                                        <div class="skill-bar d-flex">
                                            <?php foreach ($language_skills as $index => $skill): ?>
                                            <div class="skill-item">
                                                <div class="pie" data-pie='{ "index": <?php echo $index + 1; ?>, "percent": <?php echo (int)$skill['percent']; ?>, "colorSlice": "#6dc729", "colorCircle": "#f1f1f1", "fontWeight": 700, "strokeWidth": 6, "size": 90, "fontSize": "1.125rem" }'></div>
                                                <span><?php echo htmlspecialchars($skill['name']); ?></span>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="scholar-right">
                                <div class="scholar-intro">
                                    <h5><?php echo htmlspecialchars($scholar['name']); ?></h5>
                                    <span class="d-inline-block"><?php echo htmlspecialchars($scholar['title']); ?></span>
                                    <p><?php echo htmlspecialchars($scholar['bio'] ?? ''); ?></p>
                                </div>
                                <div class="scholar-info">
                                    <span class="h7 mb-3">Personal Statement</span>
                                    <p class="mb-4"><?php echo htmlspecialchars($scholar['personal_statement'] ?? ''); ?></p>
                                    <div class="scholar-other-info">
                                        <ul class="lab-ul">
                                            <?php if (!empty($scholar['scholar_address'])): ?>
                                            <li><span class="info-title">Address </span><span class="info-details">: <?php echo htmlspecialchars($scholar['scholar_address']); ?></span></li>
                                            <?php endif; ?>
                                            <?php if (!empty($scholar['scholar_email'])): ?>
                                            <li><span class="info-title">Email</span><span class="info-details">: <?php echo htmlspecialchars($scholar['scholar_email']); ?></span></li>
                                            <?php endif; ?>
                                            <?php if (!empty($scholar['scholar_phone'])): ?>
                                            <li><span class="info-title">Phone</span><span class="info-details">: <?php echo htmlspecialchars($scholar['scholar_phone']); ?></span></li>
                                            <?php endif; ?>
                                            <?php if (!empty($scholar['website'])): ?>
                                            <li><span class="info-title">Website</span><span class="info-details">: <?php echo htmlspecialchars($scholar['website']); ?></span></li>
                                            <?php endif; ?>
                                            <li><span class="info-title">Follow Us</span>
                                                <div class="info-details">
                                                    <ul class="lab-ul d-flex">
                                                        <li>: <a href="<?php echo htmlspecialchars($scholar['social_twitter'] ?? '#'); ?>" class="twitter"><i class="icofont-twitter"></i></a></li>
                                                        <li><a href="<?php echo htmlspecialchars($scholar['social_behance'] ?? '#'); ?>" class="behance"><i class="icofont-behance"></i></a></li>
                                                        <li><a href="<?php echo htmlspecialchars($scholar['social_instagram'] ?? '#'); ?>" class="instagram"><i class="icofont-instagram"></i></a></li>
                                                        <li><a href="<?php echo htmlspecialchars($scholar['social_vimeo'] ?? '#'); ?>" class="vimeo"><i class="icofont-vimeo"></i></a></li>
                                                        <li><a href="<?php echo htmlspecialchars($scholar['social_linkedin'] ?? '#'); ?>" class="linkedin"><i class="icofont-linkedin"></i></a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <?php if (!empty($awards)): ?>
                                <div class="scholar-award">
                                    <span class="h7">Recognitions Award</span>
                                    <ul class="all-awards lab-ul d-flex">
                                        <?php foreach ($awards as $award): ?>
                                        <li class="single-award">
                                            <img src="<?php echo htmlspecialchars($award['image']); ?>" alt="award">
                                            <p><?php echo htmlspecialchars($award['year']); ?></p>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scholar single section end Here -->

<?php require_once 'includes/footer.php'; ?>
