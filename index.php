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
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

// ========================================
// Mengambil Data dari Database
// ========================================

// Settings (untuk informasi header & footer)
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch();

// Social Media
$stmt = $pdo->query("SELECT * FROM social_media WHERE is_active = 1 ORDER BY order_index");
$socialMedia = $stmt->fetchAll();

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo htmlspecialchars($settings['site_title'] ?? 'Hafsa Home'); ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo htmlspecialchars($settings['favicon'] ?? 'assets/images/x-icon/01.png'); ?>">

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/icofont.min.css">
    <link rel="stylesheet" href="assets/css/lightcase.css">
    <link rel="stylesheet" href="assets/css/swiper.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <header class="header-3 pattern-1">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-xl-3 col-12">
                    <div class="mobile-menu-wrapper d-flex flex-wrap align-items-center justify-content-between">
                        <div class="header-bar d-lg-none">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="logo">
                            <a href="index.php">
                                <img src="<?php echo htmlspecialchars($settings['logo'] ?? 'assets/images/logo/01.png'); ?>" alt="logo">
                            </a>
                        </div>
                        <div class="ellepsis-bar d-lg-none">
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-12">
                    <div class="header-top">
                        <div class="header-top-area">
                            <ul class="left lab-ul">
                                <li>
                                    <i class="icofont-ui-call"></i> <span><?php echo htmlspecialchars($settings['phone'] ?? '+800-123-4567 6587'); ?></span>
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($settings['address'] ?? 'Beverley, New York 224 US'); ?>
                                </li>
                            </ul>
                            <ul class="social-icons lab-ul d-flex">
                                <?php foreach ($socialMedia as $social): ?>
                                <li>
                                    <a href="<?php echo htmlspecialchars($social['url']); ?>"><i class="<?php echo htmlspecialchars($social['icon_class']); ?>"></i></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="header-bottom">
                        <div class="header-wrapper">
                            <div class="menu-area justify-content-between w-100">
                                <ul class="menu lab-ul">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="about.html">About</a></li>
                                    <li>
                                        <a href="#0">Events</a>
                                        <ul class="submenu">
                                            <li><a href="events.html">Events</a></li>
                                            <li><a href="events-single.html">Events Single</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#0">Programs</a>
                                        <ul class="submenu">
                                            <li><a href="programs.html">Programs</a></li>
                                            <li><a href="program-single.html">Program Single</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#0">Pages</a>
                                        <ul class="submenu">
                                            <li><a href="gallery.html">Gallery</a></li>
                                            <li>
                                                <a href="#0">Scholars</a>
                                                <ul class="submenu">
                                                    <li><a href="scholar.html">Our Scholars</a></li>
                                                    <li><a href="scholar-single.html">Scholar Single</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="#0">Blog</a>
                                                <ul class="submenu">
                                                    <li><a href="blog.html">blog</a></li>
                                                    <li><a href="blog-single.html">Blog Single</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="sermons.html">Sermons</a></li>
                                            <li><a href="services.html">Service</a></li>
                                            <li><a href="404.html">404 Error</a></li>
                                            <li><a href="coming-soon.html">Coming-soon</a></li>
                                            <li><a href="registration.html">Registration</a></li>
                                            <li><a href="login.html">Login</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact.html">Contact</a></li>
                                </ul>
                                <div class="prayer-time d-none d-lg-block">
                                    <a href="#" class="prayer-time-btn"><i class="icofont-clock-time"></i> Today Prayer Time</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Banner Section -->
    <section class="banner-section">
        <div class="container">
            <div class="row align-items-center flex-column-reverse flex-md-row">
                <div class="col-md-6">
                    <div class="banner-item">
                        <div class="banner-inner">
                            <div class="banner-thumb">
                                <img src="<?php echo htmlspecialchars($banner['image'] ?? 'assets/images/banner/01.png'); ?>" alt="Banner-image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="banner-item">
                        <div class="banner-inner">
                            <div class="banner-content align-middle">
                                <h1><span class=""><?php echo $banner['title'] ?? 'And Allah Invites To <br class="d-none d-lg-block"> The'; ?> </span><?php echo $banner['subtitle'] ?? 'Home Of Peace'; ?></h1>
                                <p><?php echo htmlspecialchars($banner['description'] ?? 'The most beloved actions to Allah are those performed consistently, even if they are few'); ?></p>
                                <a href="<?php echo htmlspecialchars($banner['button_link'] ?? '#'); ?>" class="lab-btn mt-3"><?php echo htmlspecialchars($banner['button_text'] ?? 'Donate Now'); ?> <i class="icofont-heart-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section padding-tb shape-1">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-12">
                    <div class="lab-item">
                        <div class="lab-inner">
                            <div class="lab-content">
                                <div class="header-title text-start m-0">
                                    <h5><?php echo htmlspecialchars($about['title'] ?? 'About Our History'); ?></h5>
                                    <h2 class="mb-0"><?php echo htmlspecialchars($about['heading'] ?? 'Islamic Center For Muslims To Achieve Spiritual Goals'); ?></h2>
                                </div>
                                <h5 class="my-4"><?php echo htmlspecialchars($about['subheading'] ?? 'Our Promise To Uphold The Trust Placed.'); ?></h5>
                                <p><?php echo $about['description'] ?? 'Lorem ipsum dolor sit, amet consectetur adipisicing elit...'; ?></p>
                                <a href="<?php echo htmlspecialchars($about['button_link'] ?? '#'); ?>" class="lab-btn mt-4"><?php echo htmlspecialchars($about['button_text'] ?? 'Ask About Islam'); ?> <i class="icofont-heart-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <img src="<?php echo htmlspecialchars($about['image'] ?? 'assets/images/about/02.png'); ?>" alt="about-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Section -->
    <section class="feature-section bg-ash padding-tb">
        <div class="container">
            <div class="row justify-content-center">
                <?php foreach ($features as $feature): ?>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="lab-item feature-item text-xs-center">
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
            </div>
        </div>
    </section>

    <!-- Service Section -->
    <section class="service-section padding-tb padding-b shape-2">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-title">
                        <h5>Islamic Center Services</h5>
                        <h2>Ethical And Moral Beliefs That Guides To The Straight Path!</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row g-0 justify-content-center service-wrapper">
                        <?php foreach ($services as $service): ?>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="lab-item service-item">
                                <div class="lab-inner">
                                    <div class="lab-thumb">
                                        <img src="<?php echo htmlspecialchars($service['image']); ?>" alt="Service-image">
                                    </div>
                                    <div class="lab-content pattern-2">
                                        <div class="lab-content-wrapper">
                                            <div class="content-top">
                                                <div class="service-top-thumb"><img src="<?php echo htmlspecialchars($service['icon']); ?>" alt="service-icon"></div>
                                                <div class="service-top-content">
                                                    <span><?php echo htmlspecialchars($service['subtitle']); ?></span>
                                                    <h5><a href="#"><?php echo htmlspecialchars($service['title']); ?></a></h5>
                                                </div>
                                            </div>
                                            <div class="content-bottom">
                                                <p><?php echo htmlspecialchars($service['description']); ?></p>
                                                <a href="#" class="text-btn">Read More +</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Section -->
    <section class="program-section padding-tb bg-img"
        style="background: url(assets/images/program/bg.jpg) rgba(5, 21, 57, 0.7); background-blend-mode: overlay;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-title">
                        <h5>Urgent Campaign</h5>
                        <h2 class="mb-4">Free And Complete Guide To All Muslims</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="progress-item-wrapper text-center">
                        <div class="progress-item mb-4">
                            <div class="progress-bar-wrapper progress" data-percent="50%">
                                <div class="progress-bar progress-bar-striped progress-bar-animated"></div>
                            </div>
                            <div class="progress-bar-percent d-flex align-items-center justify-content-center">50
                                <sup>%</sup>
                            </div>
                            <ul class="progress-item-status lab-ul d-flex justify-content-between">
                                <li>Raised<span> $24,000</span></li>
                                <li>Gold<span> $34,900</span></li>
                            </ul>
                        </div>
                        <a href="#" class="lab-btn">Donate Now <i class="icofont-heart-alt"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Programs -->
    <div class="upcoming-programs">
        <div class="container">
            <div class="row">
                <div class="col-xl-4">
                    <div class="donation-part bg-img">
                        <div class="donation-content">
                            <h5>Help The Poor</h5>
                            <h2>Donations For The Nobel Causes</h2>
                            <p>Give the best quality of security systems and facility of latest technology for the people get awesome.</p>
                            <a href="#" class="lab-btn">See All Causes <i class="icofont-heart-alt"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="programs-item-part">
                        <div class="program-desc d-flex justify-content-between">
                            <p>We offer security solutions and cost effective service for our client are safe and secure in any situation.</p>
                            <ul class="lab-ul">
                                <li><a href="#" class="program-next"><i class="icofont-arrow-left"></i></a></li>
                                <li><a href="#" class="program-prev"><i class="icofont-arrow-right"></i></a></li>
                            </ul>
                        </div>
                        <div class="program-item-container">
                            <div class="program-item-wrapper">
                                <div class="swiper-wrapper">
                                    <?php foreach ($programs as $program): ?>
                                    <div class="swiper-slide">
                                        <div class="program-item">
                                            <div class="lab-inner">
                                                <div class="lab-thumb">
                                                    <a href="#">
                                                        <img src="<?php echo htmlspecialchars($program['image']); ?>" alt="program-image">
                                                    </a>
                                                    <div class="lab-thumb-content">
                                                        <div class="progress-item">
                                                            <ul class="progress-item-status lab-ul d-flex justify-content-between mb-2">
                                                                <li>Raised<span> <?php echo htmlspecialchars($program['raised_amount']); ?></span></li>
                                                                <li>Gold<span> <?php echo htmlspecialchars($program['goal_amount']); ?></span></li>
                                                            </ul>
                                                            <div class="progress-bar-wrapper progress" data-percent="<?php echo $program['percentage']; ?>%">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated"></div>
                                                            </div>
                                                            <div class="progress-bar-percent d-flex align-items-center justify-content-center">
                                                                <?php echo $program['percentage']; ?> <sup>%</sup>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="lab-content">
                                                    <span><?php echo htmlspecialchars($program['subtitle']); ?></span>
                                                    <h5><a href="#"><?php echo htmlspecialchars($program['title']); ?></a></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Faith Section -->
    <section class="faith-section padding-tb shape-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-title">
                        <h5>The Pillars of Islam</h5>
                        <h2>Ethical And Moral Beliefs That Guides To The Straight Path!</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="faith-content">
                        <div class="tab-content" id="pills-tabContent">
                            <?php foreach ($faiths as $index => $faith): ?>
                            <div class="tab-pane fade <?php echo $index === 0 ? 'show active' : ''; ?>" id="faith-<?php echo $faith['id']; ?>" role="tabpanel">
                                <div class="lab-item faith-item tri-shape-1 pattern-2">
                                    <div class="lab-inner d-flex align-items-center">
                                        <div class="lab-thumb">
                                            <img src="<?php echo htmlspecialchars($faith['image']); ?>" alt="faith-image">
                                        </div>
                                        <div class="lab-content">
                                            <h4><?php echo htmlspecialchars($faith['title']); ?> <span>(<?php echo htmlspecialchars($faith['subtitle']); ?>)</span></h4>
                                            <p><?php echo htmlspecialchars($faith['description']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <ul class="nav nav-pills mb-3 align-items-center justify-content-center" id="pills-tab" role="tablist">
                            <?php foreach ($faiths as $index => $faith): ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>" id="faith-tab-<?php echo $faith['id']; ?>" data-bs-toggle="pill" href="#faith-<?php echo $faith['id']; ?>" role="tab">
                                    <img src="<?php echo htmlspecialchars($faith['icon']); ?>" alt="faith-icon">
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quote Section -->
    <?php if ($quote): ?>
    <div class="qoute-section padding-tb">
        <div class="qoute-section-wrapper">
            <div class="qoute-overlay"></div>
            <div class="container">
                <div class="qoute-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="lab-item qoute-item">
                                <div class="lab-inner d-flex align-items-center">
                                    <div class="lab-thumb">
                                        <span>Quote From Prophet</span>
                                        <i class="icofont-quote-left"></i>
                                    </div>
                                    <div class="lab-content">
                                        <blockquote class="blockquote">
                                            <p><?php echo htmlspecialchars($quote['author_name']); ?> <span>"<?php echo htmlspecialchars($quote['quote_text']); ?>"</span></p>
                                            <footer class="blockquote-footer bg-transparent"><?php echo htmlspecialchars($quote['source']); ?></footer>
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
    <?php endif; ?>

    <!-- Event Section -->
    <section class="event-section padding-tb padding-b shape-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-title">
                        <h5>Upcoming Events</h5>
                        <h2>Ethical And Moral Beliefs That Guides To The Straight Path!</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="event-content">
                        <?php if (!empty($events)): ?>
                        <!-- Featured Event -->
                        <div class="event-top tri-shape-2 pattern-2">
                            <div class="event-top-thumb">
                                <img src="<?php echo htmlspecialchars($events[0]['image']); ?>" alt="Upcoming-event">
                            </div>
                            <div class="event-top-content">
                                <div class="event-top-content-wrapper">
                                    <h3><a href="#"><?php echo htmlspecialchars($events[0]['title']); ?></a></h3>
                                    <div class="date-count-wrapper">
                                        <ul class="lab-ul event-date">
                                            <li><i class="icofont-calendar"></i> <span><?php echo htmlspecialchars($events[0]['date']); ?></span></li>
                                            <li><i class="icofont-location-pin"></i> <span><?php echo htmlspecialchars($events[0]['location']); ?></span></li>
                                        </ul>
                                        <ul class="lab-ul event-count" data-date="<?php echo htmlspecialchars($events[0]['count_down_target'] ?? ''); ?>">
                                            <li><span class="days">00</span><div class="count-text">Days</div></li>
                                            <li><span class="hours">00</span><div class="count-text">Hours</div></li>
                                            <li><span class="minutes">00</span><div class="count-text">Mins</div></li>
                                            <li><span class="seconds">00</span><div class="count-text">Secs</div></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Other Events -->
                        <div class="event-bottom">
                            <div class="row justify-content-center">
                                <?php for ($i = 1; $i < count($events); $i++): ?>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="event-item lab-item">
                                        <div class="lab-inner">
                                            <div class="lab-thumb">
                                                <img src="<?php echo htmlspecialchars($events[$i]['image']); ?>" alt="event-image">
                                            </div>
                                            <div class="lab-content">
                                                <h5><a href="#"><?php echo htmlspecialchars($events[$i]['title']); ?></a></h5>
                                                <ul class="lab-ul event-date">
                                                    <li><i class="icofont-calendar"></i> <span><?php echo htmlspecialchars($events[$i]['date']); ?></span></li>
                                                    <li><i class="icofont-location-pin"></i> <span><?php echo htmlspecialchars($events[$i]['location']); ?></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer-section" style="background-image: url(assets/images/bg-images/footer-bg.png);">
        <div class="footer-top">
            <div class="container">
                <div class="row g-3 justify-content-center g-lg-0">
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="footer-top-item lab-item">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="assets/images/footer/footer-top/01.png" alt="Phone-icon">
                                </div>
                                <div class="lab-content">
                                    <span>Phone Number : <?php echo htmlspecialchars($settings['phone'] ?? '+88019 339 702 520'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="footer-top-item lab-item">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="assets/images/footer/footer-top/02.png" alt="email-icon">
                                </div>
                                <div class="lab-content">
                                    <span>Email : <?php echo htmlspecialchars($settings['email'] ?? 'admin@Hafsa.com'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="footer-top-item lab-item">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="assets/images/footer/footer-top/03.png" alt="location-icon">
                                </div>
                                <div class="lab-content">
                                    <span>Address : <?php echo htmlspecialchars($settings['address'] ?? '30 North West New York 240'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-middle padding-tb tri-shape-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="footer-middle-item-wrapper">
                            <div class="footer-middle-item mb-5 mb-lg-0">
                                <div class="fm-item-title">
                                    <h5>About <?php echo htmlspecialchars($settings['site_title'] ?? 'Hafsa'); ?></h5>
                                </div>
                                <div class="fm-item-content">
                                    <p class="mb-4"><?php echo htmlspecialchars($settings['footer_about'] ?? 'Energistically coordinate highly efficient procesr partnerships befor revolutionar growth strategie improvement'); ?></p>
                                    <img src="assets/images/footer/footer-middle/01.jpg" alt="about-image" class="footer-abt-img">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="footer-middle-item-wrapper">
                            <div class="footer-middle-item mb-5 mb-lg-0">
                                <div class="fm-item-title">
                                    <h5>Our Recent News</h5>
                                </div>
                                <div class="fm-item-content">
                                    <div class="fm-item-widget lab-item">
                                        <div class="lab-inner">
                                            <div class="lab-thumb">
                                                <a href="#"><img src="assets/images/footer/footer-middle/02.jpg" alt="footer-widget-img"></a>
                                            </div>
                                            <div class="lab-content">
                                                <h6><a href="#">Enable Seamin Matera Forin And Our Orthonal Create Vortals.</a></h6>
                                                <p>July 23, 2021</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="footer-middle-item-wrapper">
                            <div class="footer-middle-item-3 mb-5 mb-lg-0">
                                <div class="fm-item-title">
                                    <h5>OUR NEWSLETTER</h5>
                                </div>
                                <div class="fm-item-content">
                                    <p><?php echo htmlspecialchars($settings['site_title'] ?? 'Hafsa'); ?> is a nonprofit organization supported by community leaders</p>
                                    <form>
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Enter email">
                                        </div>
                                        <button type="submit" class="lab-btn">Send Message <i class="icofont-paper-plane"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="footer-bottom-content text-center">
                            <p>&copy;<?php echo date('Y'); ?> <a href="index.php"><?php echo htmlspecialchars($settings['site_title'] ?? 'Yayasan YIBBI'); ?></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll To Top -->
    <a href="#" class="scrollToTop"><i class="icofont-bubble-up"></i><span class="pluse_1"></span><span class="pluse_2"></span></a>

    <!-- JavaScript Files -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/fontawesome.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/swiper.min.js"></script>
    <script src="assets/js/circularProgressBar.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/lightcase.js"></script>
    <script src="assets/js/functions.js"></script>
</body>

</html>
