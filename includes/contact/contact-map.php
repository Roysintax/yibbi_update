<!-- Google Maps Section -->
<div class="contact-bottom">
    <div class="contac-bottom">
        <div class="row justify-content-center g-0">
            <div class="col-12">
                <div class="location-map">
                    <div id="map">
                        <iframe
                            src="<?php echo htmlspecialchars($contactSettings['map_url'] ?? 'https://www.google.com/maps/embed?pb=...'); ?>"
                            allowfullscreen=""></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
