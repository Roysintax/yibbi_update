<?php
// Settings (untuk informasi header & footer)
require_once 'config/database.php';
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch();

// Social Media
$stmt = $pdo->query("SELECT * FROM social_media WHERE is_active = 1 ORDER BY order_index");
$socialMedia = $stmt->fetchAll();

// Featured Event (for top section)
$stmt = $pdo->query("SELECT * FROM events WHERE is_active = 1 AND is_featured = 1 ORDER BY event_date ASC LIMIT 1");
$featuredEvent = $stmt->fetch();

// All Events
$stmt = $pdo->query("SELECT * FROM events WHERE is_active = 1 ORDER BY event_date ASC");
$events = $stmt->fetchAll();
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
                        <?php if ($featuredEvent): ?>
                        <div class="event-top tri-shape-2 pattern-2">
                            <div class="event-top-thumb">
                                <a href="events-single.php?id=<?php echo $featuredEvent['id']; ?>">
                                    <img src="<?php echo htmlspecialchars($featuredEvent['image']); ?>" alt="Upcoming-event">
                                </a>
                            </div>
                            <div class="event-top-content">
                                <div class="event-top-content-wrapper">
                                    <h3><a href="events-single.php?id=<?php echo $featuredEvent['id']; ?>"><?php echo htmlspecialchars($featuredEvent['title']); ?></a></h3>
                                    <div class="date-count-wrapper">
                                        <ul class="lab-ul event-date">
                                            <li><i class="icofont-calendar"></i> <span><?php echo date('F d, Y', strtotime($featuredEvent['event_date'])); ?></span></li>
                                            <li><i class="icofont-location-pin"></i> <span><?php echo htmlspecialchars($featuredEvent['location'] ?? 'TBD'); ?></span></li>
                                        </ul>
                                        <ul class="lab-ul event-count" data-date="<?php echo date('F d, Y H:i:s', strtotime($featuredEvent['event_date'])); ?>">
                                            <li>
                                                <span class="days">00</span>
                                                <div class="count-text">Days</div>
                                            </li>
                                            <li>
                                                <span class="hours">00</span>
                                                <div class="count-text">Hours</div>
                                            </li>
                                            <li>
                                                <span class="minutes">00</span>
                                                <div class="count-text">Mins</div>
                                            </li>
                                            <li>
                                                <span class="seconds">00</span>
                                                <div class="count-text">Secs</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="event-bottom">
                            <div class="row justify-content-center">
                                <?php foreach ($events as $event): ?>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="event-item lab-item mb-4">
                                        <div class="lab-inner">
                                            <div class="lab-thumb">
                                                <a href="events-single.php?id=<?php echo $event['id']; ?>">
                                                    <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="event-image">
                                                </a>
                                            </div>
                                            <div class="lab-content">
                                                <h5><a href="events-single.php?id=<?php echo $event['id']; ?>"><?php echo htmlspecialchars($event['title']); ?></a></h5>
                                                <ul class="lab-ul event-date">
                                                    <li><i class="icofont-calendar"></i> <span><?php echo date('F d, Y', strtotime($event['event_date'])); ?></span>
                                                    </li>
                                                    <li><i class="icofont-location-pin"></i> <span><?php echo htmlspecialchars($event['location'] ?? 'TBD'); ?></span></li>
                                                </ul>
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
    </section>
    <!-- Events Section end here -->

<?php include 'includes/footer.php'; ?>