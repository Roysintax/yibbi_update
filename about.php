<?php
// Settings (untuk informasi header & footer)
require_once 'config/database.php';
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch();

// Social Media
$stmt = $pdo->query("SELECT * FROM social_media WHERE is_active = 1 ORDER BY order_index");
$socialMedia = $stmt->fetchAll();

// About Settings
$stmt = $pdo->query("SELECT * FROM about_section LIMIT 1");
$aboutSettings = $stmt->fetch();

// About History
$stmt = $pdo->query("SELECT * FROM about_history LIMIT 1");
// About History
$stmt = $pdo->query("SELECT * FROM about_history LIMIT 1");
$aboutHistory = $stmt->fetch();

// About Achievements
$stmt = $pdo->query("SELECT * FROM about_achievements ORDER BY order_index ASC");
$aboutAchievements = $stmt->fetchAll();

// About Features
$stmt = $pdo->query("SELECT * FROM features ORDER BY display_order ASC");
$aboutFeatures = $stmt->fetchAll();

// Scholars
$stmt = $pdo->query("SELECT * FROM scholars ORDER BY id ASC");
$scholars = $stmt->fetchAll();

// Quote
$stmt = $pdo->query("SELECT * FROM quotes WHERE is_active = 1 LIMIT 1");
$aboutQuote = $stmt->fetch();

// Faith (Pillars of Islam)
$stmt = $pdo->query("SELECT * FROM faiths ORDER BY order_index ASC");
$aboutFaith = $stmt->fetchAll();
?>
<!-- Include Header -->
<?php include 'includes/header.php'; ?>

    <!-- Bagian Header Halaman Dimulai Di Sini -->
    <!-- Bagian Header Halaman Dimulai Di Sini -->
    <section class="page-header bg_img padding-tb">
        <div class="overlay"></div>
        <div class="container">
            <div class="page-header-content-area">
                <h4 class="ph-title"><?php echo htmlspecialchars($aboutSettings['title'] ?? 'About Our Y-ibbi'); ?></h4>
                <ul class="lab-ul">
                    <li><a href="index.php">Home</a></li>
                    <li><a class="active">About</a></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Bagian Header Halaman Berakhir Di Sini -->
    <!-- Bagian Header Halaman Berakhir Di Sini -->

    <!-- Bagian About (Tentang) Dimulai Di Sini -->
    <section class="about-section padding-tb shape-1">
        <div class="container">
            <div class="row align-items-center">
                <!-- Kolom Teks About -->
                <div class="col-lg-6 col-12">
                    <div class="lab-item">
                        <div class="lab-inner">
                            <div class="lab-content">
                                <div class="header-title text-start m-0">
                                    <h5><?php echo htmlspecialchars($aboutHistory['subtitle'] ?? 'Since 1990'); ?></h5>
                                    <h2 class="mb-0"><?php echo htmlspecialchars($aboutHistory['title'] ?? 'Our History'); ?></h2>
                                </div>
                                <h5 class="my-4"><?php echo htmlspecialchars($aboutHistory['achievements_title'] ?? 'Our Achievements'); ?></h5>
                                <?php echo $aboutHistory['description'] ?? ''; ?>
                                <a href="#" class="lab-btn mt-4">Ask About Islam <i class="icofont-heart-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Kolom Gambar About -->
                <div class="col-lg-6 col-12">
                    <div class="lab-item">
                        <div class="lab-inner">
                            <div class="lab-thumb">
                                <div class="img-grp">
                                    <div class="about-circle-wrapper">
                                        <div class="about-circle-2"></div>
                                        <div class="about-circle"></div>
                                    </div>
                                    <div class="about-fg-img">
                                        <img src="<?php echo htmlspecialchars($aboutHistory['image'] ?? 'assets/images/about/02.png'); ?>" alt="about-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Bagian About Berakhir Di Sini -->

    <!-- Bagian Fitur Dimulai Di Sini -->
    <section class="feature-section bg-ash padding-tb">
        <div class="container">
            <div class="row justify-content-center">
                <?php if ($aboutFeatures): ?>
                    <?php foreach ($aboutFeatures as $index => $feature): ?>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="lab-item feature-item <?php echo $index === 0 ? 'text-xs-center' : ''; ?>">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="<?php echo htmlspecialchars($feature['image']); ?>" alt="feature-image">
                                </div>
                                <div class="lab-content">
                                    <h5><?php echo htmlspecialchars($feature['title']); ?></h5>
                                    <p><?php echo htmlspecialchars($feature['description']); ?></p>
                                    <a href="<?php echo htmlspecialchars($feature['button_link']); ?>" class="text-btn"><?php echo htmlspecialchars($feature['button_text']); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        </div>
    </section>
    <!-- Bagian Fitur Berakhir Di Sini -->

    <!-- Bagian Tim (Ulama) Dimulai Di Sini -->
    <section class="team-section padding-tb">
        <div class="container">
            <div class="row">
                <!-- Judul Bagian Tim -->
                <div class="col-12">
                    <div class="header-title">
                        <h5>Board Of Scholors</h5>
                        <h2>Our Scholar Whose Knowledge Is
                            Useful For Others</h2>
                    </div>
                </div>
                <!-- Daftar Anggota Tim -->
                <div class="col-12">
                    <div class="row justify-content-center pb-10">
                        <?php if ($scholars): ?>
                            <?php foreach ($scholars as $scholar): ?>
                            <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                                <div class="card text-center border-none team-item-1">
                                    <div class="lab-inner">
                                        <div class="lab-thumb">
                                            <img src="<?php echo htmlspecialchars($scholar['image']); ?>" class="card-img-top" alt="product">
                                        </div>
                                        <div class="lab-content">
                                            <a href="#">
                                                <h6 class="card-title mb-0"><?php echo htmlspecialchars($scholar['name']); ?></h6>
                                            </a>
                                            <p class="card-text mb-3"><?php echo htmlspecialchars($scholar['title']); ?></p>
                                            <div class="social-share">
                                                <a href="<?php echo htmlspecialchars($scholar['social_twitter']); ?>" class="m-1 twitter"><i class="icofont-twitter"></i></a>
                                                <a href="<?php echo htmlspecialchars($scholar['social_behance']); ?>" class="m-1 behance"><i class="icofont-behance"></i></a>
                                                <a href="<?php echo htmlspecialchars($scholar['social_instagram']); ?>" class="m-1 instagram"><i class="icofont-instagram"></i></a>
                                                <a href="<?php echo htmlspecialchars($scholar['social_vimeo']); ?>" class="m-1 vimeo"><i class="icofont-vimeo"></i></a>
                                                <a href="<?php echo htmlspecialchars($scholar['social_linkedin']); ?>" class="m-1 linkedin"><i class="icofont-linkedin"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Bagian Tim Berakhir Di Sini -->

    <!-- Bagian Quote (Kutipan) Dimulai Di Sini -->
    <div class="qoute-section padding-tb">
        <div class="qoute-section-wrapper">
            <div class="qoute-overlay"></div>
            <div class="container">
                <div class="qoute-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="lab-item qoute-item">
                                <div class="lab-inner d-flex align-items-center">
                                    <!-- Ikon/Gambar Kutipan -->
                                    <div class="lab-thumb">
                                        <span>Quote From
                                            Prophat</span>
                                        <i class="icofont-quote-left"></i>
                                    </div>
                                    <!-- Isi Kutipan -->
                                    <div class="lab-content">
                                        <blockquote class="blockquote">
                                            <p><?php echo htmlspecialchars($aboutQuote['author'] ?? 'Unknown'); ?> <span>"<?php echo htmlspecialchars($aboutQuote['quote_text'] ?? 'No quote available.'); ?>"</span> </p>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bagian Quote Berakhir Di Sini -->

    <!-- Bagian Faith (Rukun Islam) Dimulai Di Sini -->
    <section class="faith-section padding-tb shape-3">
        <div class="container">
            <div class="row">
                <!-- Judul Bagian Faith -->
                <div class="col-12">
                    <div class="header-title">
                        <h5>The Pillars of Islam</h5>
                        <h2>Ethical And Moral Beliefs That Guides
                            To The Straight Path!</h2>
                    </div>
                </div>
                <!-- Konten Tab Faith -->
                <div class="col-12">
                    <div class="faith-content">
                        <!-- Konten Tab Pane -->
                        <div class="tab-content" id="pills-tabContent">
                            <?php foreach ($aboutFaith as $index => $item): ?>
                                <?php 
                                    $isActive = $index === 0 ? 'show active' : '';
                                    $identifier = 'faith-' . $item['id'];
                                ?>
                                <div class="tab-pane fade <?php echo $isActive; ?>" id="<?php echo $identifier; ?>" role="tabpanel" aria-labelledby="<?php echo $identifier; ?>-tab">
                                    <div class="lab-item faith-item tri-shape-1 pattern-2">
                                        <div class="lab-inner d-flex align-items-center">
                                            <div class="lab-thumb">
                                                <img src="<?php echo htmlspecialchars($item['icon']); ?>" alt="faith-image">
                                            </div>
                                            <div class="lab-content">
                                                <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                                                <p><?php echo htmlspecialchars($item['description']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Navigasi Tab (Ikon-ikon Rukun Islam) -->
                        <ul class="nav nav-pills mb-3 align-items-center justify-content-center" id="pills-tab" role="tablist">
                            <?php foreach ($aboutFaith as $index => $item): ?>
                                <?php 
                                    $isActiveLink = $index === 0 ? 'active' : '';
                                    $ariaSelected = $index === 0 ? 'true' : 'false';
                                    $identifier = 'faith-' . $item['id'];
                                ?>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link <?php echo $isActiveLink; ?>" id="<?php echo $identifier; ?>-tab" data-bs-toggle="pill" href="#<?php echo $identifier; ?>" role="tab" aria-controls="<?php echo $identifier; ?>" aria-selected="<?php echo $ariaSelected; ?>">
                                        <img src="<?php echo htmlspecialchars($item['icon']); ?>" alt="faith-icon">
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Bagian Faith Berakhir Di Sini -->

    <!-- Bagian Footer Dimulai Di Sini -->
    <?php include 'includes/footer.php'; ?>