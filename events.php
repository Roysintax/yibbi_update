<?php
// Settings (untuk informasi header & footer)
require_once 'admin/config/database.php';
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch();

// Social Media
$stmt = $pdo->query("SELECT * FROM social_media WHERE is_active = 1 ORDER BY order_index");
$socialMedia = $stmt->fetchAll();

// TODO: Query untuk events dari database (saat ini masih static)
// Untuk sementara, data events masih hardcoded di HTML sampai tabel events dibuat
?>
<?php include 'includes/header.php'; ?>

    <!-- Page Header Section Start Here -->
    <section class="page-header bg_img padding-tb">
        <div class="overlay"></div>
        <div class="container">
            <div class="page-header-content-area">
                <h4 class="ph-title">Our Upcoming Events</h4>
                <ul class="lab-ul">
                    <li><a href="index.php">Home</a></li>
                    <li><a class="active">Events</a></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Page Header Section Ending Here -->


    <!-- Events Section start here -->
    <section class="event-section padding-tb padding-b shape-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-title">
                        <h5>Upcoming Events</h5>
                        <h2>Ethical And Moral Beliefs That Guides
                            To The Straight Path!</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="event-content">
                        <div class="event-top tri-shape-2 pattern-2">
                            <div class="event-top-thumb">
                                <img src="assets/images/event/01.jpg" alt="Upcoming-event">
                            </div>
                            <div class="event-top-content">
                                <div class="event-top-content-wrapper">
                                    <h3><a href="#">Helping Hands For Poor People
                                            Marriage Event</a> </h3>
                                    <div class="date-count-wrapper">
                                        <ul class="lab-ul event-date">
                                            <li><i class="icofont-calendar"></i> <span>December 24,2021</span></li>
                                            <li><i class="icofont-location-pin"></i> <span>New York AK United
                                                    States</span></li>
                                        </ul>
                                        <ul class="lab-ul event-count" data-date="July 05, 2021 21:14:01">
                                            <li>
                                                <span class="days">34</span>
                                                <div class="count-text">Days</div>
                                            </li>
                                            <li>
                                                <span class="hours">09</span>
                                                <div class="count-text">Hours</div>
                                            </li>
                                            <li>
                                                <span class="minutes">32</span>
                                                <div class="count-text">Muni</div>
                                            </li>
                                            <li>
                                                <span class="seconds">32</span>
                                                <div class="count-text">Seco</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="event-bottom">
                            <div class="row justify-content-center">
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="event-item lab-item mb-4">
                                        <div class="lab-inner">
                                            <div class="lab-thumb">
                                                <img src="assets/images/event/02.jpg" alt="event-image">
                                            </div>
                                            <div class="lab-content">
                                                <h5><a href="#">If Islam Teaches Peace, Why Are
                                                        there Radical Muslims?</a> </h5>
                                                <ul class="lab-ul event-date">
                                                    <li><i class="icofont-calendar"></i> <span>December 24,2021</span>
                                                    </li>
                                                    <li><i class="icofont-location-pin"></i> <span>New York AK United
                                                            States</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md col-12">
                                    <div class="event-item lab-item mb-4">
                                        <div class="lab-inner">
                                            <div class="lab-thumb">
                                                <img src="assets/images/event/03.jpg" alt="event-image">
                                            </div>
                                            <div class="lab-content">
                                                <h5><a href="#">American Muslim: Choosing Remain
                                                        Still This Ramadan</a> </h5>
                                                <ul class="lab-ul event-date">
                                                    <li><i class="icofont-calendar"></i> <span>December 24,2021</span>
                                                    </li>
                                                    <li><i class="icofont-location-pin"></i> <span>New York AK United
                                                            States</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="event-item lab-item mb-4">
                                        <div class="lab-inner">
                                            <div class="lab-thumb">
                                                <img src="assets/images/event/04.jpg" alt="event-image">
                                            </div>
                                            <div class="lab-content">
                                                <h5><a href="#"> How To Teach Kids Ramadan
                                                        Isn't About Food</a></h5>
                                                <ul class="lab-ul event-date">
                                                    <li><i class="icofont-calendar"></i> <span>December 24,2021</span>
                                                    </li>
                                                    <li><i class="icofont-location-pin"></i> <span>New York AK United
                                                            States</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="event-item lab-item">
                                        <div class="lab-inner">
                                            <div class="lab-thumb">
                                                <img src="assets/images/event/05.jpg" alt="event-image">
                                            </div>
                                            <div class="lab-content">
                                                <h5><a href="#">If Islam Teaches Peace, Why Are
                                                        there Radical Muslims?</a> </h5>
                                                <ul class="lab-ul event-date">
                                                    <li><i class="icofont-calendar"></i> <span>December 24,2021</span>
                                                    </li>
                                                    <li><i class="icofont-location-pin"></i> <span>New York AK United
                                                            States</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md col-12">
                                    <div class="event-item lab-item">
                                        <div class="lab-inner">
                                            <div class="lab-thumb">
                                                <img src="assets/images/event/06.jpg" alt="event-image">
                                            </div>
                                            <div class="lab-content">
                                                <h5><a href="#">American Muslim: Choosing Remain
                                                        Still This Ramadan</a> </h5>
                                                <ul class="lab-ul event-date">
                                                    <li><i class="icofont-calendar"></i> <span>December 24,2021</span>
                                                    </li>
                                                    <li><i class="icofont-location-pin"></i> <span>New York AK United
                                                            States</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="event-item lab-item">
                                        <div class="lab-inner">
                                            <div class="lab-thumb">
                                                <img src="assets/images/event/07.jpg" alt="event-image">
                                            </div>
                                            <div class="lab-content">
                                                <h5><a href="#"> How To Teach Kids Ramadan
                                                        Isn't About Food</a></h5>
                                                <ul class="lab-ul event-date">
                                                    <li><i class="icofont-calendar"></i> <span>December 24,2021</span>
                                                    </li>
                                                    <li><i class="icofont-location-pin"></i> <span>New York AK United
                                                            States</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Events Section end here -->

<?php include 'includes/footer.php'; ?>