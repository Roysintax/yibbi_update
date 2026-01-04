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
