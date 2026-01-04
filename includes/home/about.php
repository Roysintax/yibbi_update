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
