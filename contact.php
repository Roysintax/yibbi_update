<?php
// Settings (untuk informasi header & footer)
require_once 'admin/config/database.php';
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
                        <article class="contact-form-wrapper">
                            <div class="contact-form">
                                <h4><?php echo htmlspecialchars($contactSettings['form_title'] ?? "Don't Be A Stranger Just Say Hello."); ?></h4>
                                <p class="mb-5"><?php echo htmlspecialchars($contactSettings['form_description'] ?? 'We do fast phone repair...'); ?></p>
                                <form action="#" method="POST" id="commentform" class="comment-form">
                                    <input type="text" name="name" class="" placeholder="Name*">
                                    <input type="email" name="email" class="" placeholder="Email*">
                                    <input type="text" name="subject" class="" placeholder="Subject*">
                                    <!-- Removed duplicate name/email inputs found in original -->
                                    <textarea name="message" id="role" cols="30" rows="9"
                                        placeholder="Message*"></textarea>
                                    <button type="submit" class="lab-btn">
                                        <span>Send Our Message</span>
                                    </button>
                                </form>
                            </div>
                        </article>
                    </div>
                    <div class="col-lg-4">
                        <div class="contact-info-wrapper">
                            <div class="contact-info-title">
                                <h5>Get Information</h5>
                                <p>Our Contact information Details and
                                    Follow us on social media</p>
                            </div>
                            <div class="contact-info-content">
                                <?php if (count($contactInfo) > 0): ?>
                                    <?php foreach($contactInfo as $info): ?>
                                    <div class="contact-info-item">
                                        <div class="contact-info-inner">
                                            <div class="contact-info-thumb">
                                                <img src="<?php echo htmlspecialchars($info['icon']); ?>" alt="icon">
                                            </div>
                                            <div class="contact-info-details">
                                                <span class="fw-bold"><?php echo htmlspecialchars($info['title']); ?></span>
                                                <p><?php echo htmlspecialchars($info['description']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- Fallback if no data -->
                                    <p>No contact info available.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-bottom">
            <div class="contac-bottom">
                <div class="row justify-content-center g-0">
                    <div class="col-12">
                        <div class="location-map">
                            <div id="map">
                                <iframe
                                    src="<?php echo htmlspecialchars($contactSettings['map_url'] ?? 'https://www.google.com/maps/embed?pb=...'); ?>"
                                    allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Contact Us Section ENding Here -->

    <!-- Footer Section start here -->
    <?php include 'includes/footer.php'; ?>