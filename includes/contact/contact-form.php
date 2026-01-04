<!-- Contact Form Section -->
<article class="contact-form-wrapper">
    <div class="contact-form">
        <h4><?php echo htmlspecialchars($contactSettings['form_title'] ?? "Don't Be A Stranger Just Say Hello."); ?></h4>
        <p class="mb-5"><?php echo htmlspecialchars($contactSettings['form_description'] ?? 'We do fast phone repair...'); ?></p>
        <form action="#" method="POST" id="commentform" class="comment-form">
            <input type="text" name="name" class="" placeholder="Name*" required>
            <input type="email" name="email" class="" placeholder="Email*" required>
            <input type="text" name="subject" class="" placeholder="Subject*" required>
            <textarea name="message" id="role" cols="30" rows="9" placeholder="Message*" required></textarea>
            <button type="submit" class="lab-btn">
                <span>Send Our Message</span>
            </button>
        </form>
    </div>
</article>
