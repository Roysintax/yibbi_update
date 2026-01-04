<?php
// Settings (untuk informasi header & footer)
require_once 'config/database.php';
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch();

// Social Media
$stmt = $pdo->query("SELECT * FROM social_media WHERE is_active = 1 ORDER BY order_index");
$socialMedia = $stmt->fetchAll();

// Get Event ID from URL
$eventId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch the specific event
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ? AND is_active = 1");
$stmt->execute([$eventId]);
$event = $stmt->fetch();

// Redirect if event not found
if (!$event) {
    header('Location: events.php');
    exit;
}

// Fetch other events for sidebar
$stmt = $pdo->prepare("SELECT * FROM events WHERE is_active = 1 AND id != ? ORDER BY event_date ASC LIMIT 3");
$stmt->execute([$eventId]);
$otherEvents = $stmt->fetchAll();
?>
<?php include 'includes/header.php'; ?>

    <!-- Page Header Section Start Here -->
    <section class="page-header bg_img padding-tb">
        <div class="overlay"></div>
        <div class="container">
            <div class="page-header-content-area">
                <h4 class="ph-title"><?php echo htmlspecialchars($event['title']); ?></h4>
                <ul class="lab-ul">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="events.php">Events</a></li>
                    <li><a class="active">Event Details</a></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Page Header Section Ending Here -->

    <!-- Event Single Section Start Here -->
    <div class="event-single-section padding-tb aside-bg">
        <div class="container">
            <div class="section-wrapper">
                <div class="row justify-content-center pb-10">
                    <div class="col-xl-8 col-lg-7 col-12">
                        <div class="event-single-wrapper">
                            <div class="event-top event-top-2">
                                <div class="event-top-thumb">
                                    <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
                                </div>
                                <div class="event-top-content">
                                    <div class="event-top-content-wrapper mb-30">
                                        <ul class="lab-ul event-date mb-4 mb-md-0">
                                            <li><i class="icofont-calendar"></i> <span><?php echo date('F d, Y', strtotime($event['event_date'])); ?></span></li>
                                            <li><i class="icofont-location-pin"></i> <span><?php echo htmlspecialchars($event['location'] ?? 'TBD'); ?></span></li>
                                        </ul>
                                        <ul class="lab-ul event-count" data-date="<?php echo date('F d, Y H:i:s', strtotime($event['event_date'])); ?>">
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
                                    <div class="event-description">
                                        <?php echo $event['description']; ?>
                                    </div>
                                    <div class="tags-area mt-4">
                                        <?php if (!empty($event['category'])): ?>
                                        <ul class="tags lab-ul justify-content-center">
                                            <li>
                                                <a href="#" class="active"><?php echo htmlspecialchars($event['category']); ?></a>
                                            </li>
                                        </ul>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5 col-12">
                        <aside class="lab-aside">
                            <div class="widget widget-event mt-5 mt-lg-0">
                                <div class="widget-header">
                                    <h5>Event Details</h5>
                                </div>
                                <ul class="lab-ul widget-wrapper">
                                    <li>
                                        <span><i class="icofont-ui-calendar"></i> Event Date </span> <span>:
                                            <?php echo date('d/m/Y', strtotime($event['event_date'])); ?></span>
                                    </li>
                                    <li>
                                        <span><i class="icofont-clock-time"></i> Event Time </span> <span>: <?php echo date('h:i A', strtotime($event['event_date'])); ?></span>
                                    </li>
                                    <li>
                                        <span><i class="icofont-home"></i> Location </span> <span>: <?php echo htmlspecialchars($event['location'] ?? 'TBD'); ?></span>
                                    </li>
                                    <li>
                                        <span><i class="icofont-user"></i> Organizer </span> <span>:
                                            <?php echo htmlspecialchars($event['organizer'] ?? 'Y-ibbi'); ?></span>
                                    </li>
                                    <?php if (!empty($event['category'])): ?>
                                    <li>
                                        <span><i class="icofont-tag"></i> Category </span> <span>:
                                            <?php echo htmlspecialchars($event['category']); ?></span>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            
                            <?php if (count($otherEvents) > 0): ?>
                            <div class="widget widget-program mt-4">
                                <div class="widget-header">
                                    <h5>Other Events</h5>
                                </div>
                                <div class="widget-wrapper">
                                    <?php foreach ($otherEvents as $otherEvent): ?>
                                    <div class="event-item lab-item mb-4">
                                        <div class="lab-inner">
                                            <div class="lab-thumb">
                                                <a href="events-single.php?id=<?php echo $otherEvent['id']; ?>">
                                                    <img src="<?php echo htmlspecialchars($otherEvent['image']); ?>" alt="event-image">
                                                </a>
                                            </div>
                                            <div class="lab-content">
                                                <h6><a href="events-single.php?id=<?php echo $otherEvent['id']; ?>"><?php echo htmlspecialchars($otherEvent['title']); ?></a></h6>
                                                <p><i class="icofont-calendar"></i> <?php echo date('M d, Y', strtotime($otherEvent['event_date'])); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Single Section Ending Here -->

<?php include 'includes/footer.php'; ?>