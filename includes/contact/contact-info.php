<!-- Contact Info Cards Section -->
<div class="contact-info-wrapper">
    <div class="contact-info-title">
        <h5>Get Information</h5>
        <p>Our Contact information Details and Follow us on social media</p>
    </div>
    <div class="contact-info-content">
        <?php if (count($contactInfo) > 0): ?>
            <?php foreach($contactInfo as $info): ?>
            <div class="contact-info-item">
                <div class="contact-info-inner">
                    <div class="contact-info-thumb">
                        <img src="<?php echo htmlspecialchars($info['icon']); ?>" alt="icon">
                    </div>
                    <div class="contact-info-details">
                        <span class="fw-bold"><?php echo htmlspecialchars($info['title']); ?></span>
                        <p><?php echo htmlspecialchars($info['description']); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback if no data -->
            <p>No contact info available.</p>
        <?php endif; ?>
    </div>
</div>
