<?php
// Settings (untuk informasi header & footer)
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch();

// Social Media
$stmt = $pdo->query("SELECT * FROM social_media WHERE is_active = 1 ORDER BY order_index");
$socialMedia = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo htmlspecialchars($settings['site_title'] ?? 'Y-ibbi Home'); ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL . htmlspecialchars($settings['favicon'] ?? 'assets/images/x-icon/01.png'); ?>">

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/icofont.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/lightcase.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/swiper.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
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
                                    <li><a href="about.php">About</a></li>
                                    <li>
                                        <a href="#0">Events</a>
                                        <ul class="submenu">
                                            <li><a href="<?php echo BASE_URL; ?>events.php">Events</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#0">Programs</a>
                                        <ul class="submenu">
                                            <li><a href="<?php echo BASE_URL; ?>programs.php">Programs</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#0">Blog</a>
                                        <ul class="submenu">
                                            <li><a href="<?php echo BASE_URL; ?>blog.php">Blog</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#0">Pages</a>
                                        <ul class="submenu">
                                            <li><a href="<?php echo BASE_URL; ?>gallery.php">Gallery</a></li>
                                            <li><a href="<?php echo BASE_URL; ?>scholar.php">Scholars</a></li>
                                            <li><a href="<?php echo BASE_URL; ?>donate.php">Donate</a></li>
                                            <li><a href="<?php echo BASE_URL; ?>404.php">404 Error</a></li>
                                            <li><a href="<?php echo BASE_URL; ?>coming-soon.php">Coming Soon</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="<?php echo BASE_URL; ?>contact.php">Contact</a></li>

                                </ul>
                                <div class="prayer-time d-none d-lg-block">
                                    <a href="<?php echo BASE_URL; ?>donate.php" class="prayer-time-btn"><i class="fas fa-hand-holding-heart"></i> Donate Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
