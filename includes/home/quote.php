    <!-- Quote Section -->
    <?php if ($quote): ?>
    <div class="qoute-section padding-tb">
        <div class="qoute-section-wrapper">
            <div class="qoute-overlay"></div>
            <div class="container">
                <div class="qoute-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="lab-item qoute-item">
                                <div class="lab-inner d-flex align-items-center">
                                    <div class="lab-thumb">
                                        <span>Quote From Prophet</span>
                                        <i class="icofont-quote-left"></i>
                                    </div>
                                    <div class="lab-content">
                                        <blockquote class="blockquote">
                                            <p><?php echo htmlspecialchars($quote['author_name']); ?> <span>"<?php echo htmlspecialchars($quote['quote_text']); ?>"</span></p>
                                            <footer class="blockquote-footer bg-transparent"><?php echo htmlspecialchars($quote['source']); ?></footer>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
