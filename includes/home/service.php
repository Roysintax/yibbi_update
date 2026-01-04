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
