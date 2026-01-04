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
