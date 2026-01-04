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
                            <a href="programs.php" class="lab-btn">See All Causes <i class="icofont-heart-alt"></i></a>
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
                                                                <li>Raised<span> $<?php echo number_format($program['amount_raised'], 0); ?></span></li>
                                                                <li>Goal<span> $<?php echo number_format($program['target_amount'], 0); ?></span></li>
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
                                                    <span><?php echo htmlspecialchars($program['category'] ?? 'Program'); ?></span>
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
