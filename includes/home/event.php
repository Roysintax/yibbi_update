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
                                <a href="events-single.php?id=<?php echo $events[0]['id']; ?>">
                                    <img src="<?php echo htmlspecialchars($events[0]['image']); ?>" alt="Upcoming-event">
                                </a>
                            </div>
                            <div class="event-top-content">
                                <div class="event-top-content-wrapper">
                                    <h3><a href="events-single.php?id=<?php echo $events[0]['id']; ?>"><?php echo htmlspecialchars($events[0]['title']); ?></a></h3>
                                    <div class="date-count-wrapper">
                                        <ul class="lab-ul event-date">
                                            <li><i class="icofont-calendar"></i> <span><?php echo htmlspecialchars(date('F d, Y', strtotime($events[0]['event_date']))); ?></span></li>
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
                                                <a href="events-single.php?id=<?php echo $events[$i]['id']; ?>">
                                                    <img src="<?php echo htmlspecialchars($events[$i]['image']); ?>" alt="event-image">
                                                </a>
                                            </div>
                                            <div class="lab-content">
                                                <h5><a href="events-single.php?id=<?php echo $events[$i]['id']; ?>"><?php echo htmlspecialchars($events[$i]['title']); ?></a></h5>
                                                <ul class="lab-ul event-date">
                                                    <li><i class="icofont-calendar"></i> <span><?php echo htmlspecialchars(date('F d, Y', strtotime($events[$i]['event_date']))); ?></span></li>
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
