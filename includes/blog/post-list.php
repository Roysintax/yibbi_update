<?php if (count($posts) > 0): ?>
    <?php foreach ($posts as $post): ?>
        
        <!-- Tipe 4: Quote (Kutipan) -->
        <?php if ($post['type'] == 'quote'): ?>
            <div class="post-item-2">
                <div class="post-inner">
                    <div class="post-thumb">
                        <blockquote class="blog-quote text-center">
                            <div class="quotes">
                                <?php echo htmlspecialchars($post['quote_text']); ?>
                            </div>
                        </blockquote>
                    </div>
                    <div class="post-content">
                        <a href="blog-single.php?slug=<?php echo $post['slug']; ?>">
                            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                        </a>
                        <ul class="lab-ul post-date">
                            <li><span><i class="icofont-ui-calendar"></i> <?php echo date('F j, Y g:i a', strtotime($post['published_at'])); ?></span></li>
                            <li><span><i class="icofont-user"></i><a href="#"><?php echo htmlspecialchars($post['author']); ?></a></span></li>
                            <li><span><i class="icofont-speech-comments"></i><a href="#"><?php echo str_pad($post['comment_count'], 2, '0', STR_PAD_LEFT); ?> Comments</a></span></li>
                        </ul>
                        <p><?php echo htmlspecialchars($post['excerpt']); ?></p>
                        <a href="blog-single.php?slug=<?php echo $post['slug']; ?>" class="lab-btn">Read More</a>
                    </div>
                </div>
            </div>

        <!-- Tipe 3: Video -->
        <?php elseif ($post['type'] == 'video'): ?>
            <div class="post-item-2">
                <div class="post-inner">
                    <div class="post-thumb">
                        <a href="blog-single.php?slug=<?php echo $post['slug']; ?>">
                            <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="blog">
                        </a>
                        <!-- Tombol Play Video -->
                        <a href="<?php echo htmlspecialchars($post['video_url']); ?>" class="play-btn" data-rel="lightcase">
                            <i class="icofont-play"></i>
                            <span class="pluse_2"></span>
                        </a>
                    </div>
                    <div class="post-content">
                        <a href="blog-single.php?slug=<?php echo $post['slug']; ?>">
                            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                        </a>
                        <ul class="lab-ul post-date">
                            <li><span><i class="icofont-ui-calendar"></i> <?php echo date('F j, Y g:i a', strtotime($post['published_at'])); ?></span></li>
                            <li><span><i class="icofont-user"></i><a href="#"><?php echo htmlspecialchars($post['author']); ?></a></span></li>
                            <li><span><i class="icofont-speech-comments"></i><a href="#"><?php echo str_pad($post['comment_count'], 2, '0', STR_PAD_LEFT); ?> Comments</a></span></li>
                        </ul>
                        <p><?php echo htmlspecialchars($post['excerpt']); ?></p>
                        <a href="blog-single.php?slug=<?php echo $post['slug']; ?>" class="lab-btn">Read More</a>
                    </div>
                </div>
            </div>

        <!-- Tipe 2: Slide -->
        <?php elseif ($post['type'] == 'slide'): ?>
            <div class="post-item-2">
                <div class="post-inner">
                    <div class="post-thumb">
                        <a href="blog-single.php?slug=<?php echo $post['slug']; ?>">
                            <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="blog">
                        </a>
                    </div>
                    <div class="post-content">
                        <a href="blog-single.php?slug=<?php echo $post['slug']; ?>">
                            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                        </a>
                        <ul class="lab-ul post-date">
                            <li><span><i class="icofont-ui-calendar"></i> <?php echo date('F j, Y g:i a', strtotime($post['published_at'])); ?></span></li>
                            <li><span><i class="icofont-user"></i><a href="#"><?php echo htmlspecialchars($post['author']); ?></a></span></li>
                            <li><span><i class="icofont-speech-comments"></i><a href="#"><?php echo str_pad($post['comment_count'], 2, '0', STR_PAD_LEFT); ?> Comments</a></span></li>
                        </ul>
                        <p><?php echo htmlspecialchars($post['excerpt']); ?></p>
                        <a href="blog-single.php?slug=<?php echo $post['slug']; ?>" class="lab-btn">Read More</a>
                    </div>
                </div>
            </div>

        <!-- Tipe 1: Standard (Default) -->
        <?php else: ?>
            <div class="post-item-2">
                <div class="post-inner">
                    <div class="post-thumb">
                        <a href="blog-single.php?slug=<?php echo $post['slug']; ?>">
                            <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="blog">
                        </a>
                    </div>
                    <div class="post-content">
                        <a href="blog-single.php?slug=<?php echo $post['slug']; ?>">
                            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                        </a>
                        <ul class="lab-ul post-date">
                            <li><span><i class="icofont-ui-calendar"></i> <?php echo date('F j, Y g:i a', strtotime($post['published_at'])); ?></span></li>
                            <li><span><i class="icofont-user"></i><a href="#"><?php echo htmlspecialchars($post['author']); ?></a></span></li>
                            <li><span><i class="icofont-speech-comments"></i><a href="#"><?php echo str_pad($post['comment_count'], 2, '0', STR_PAD_LEFT); ?> Comments</a></span></li>
                        </ul>
                        <p><?php echo htmlspecialchars($post['excerpt']); ?></p>
                        <a href="blog-single.php?slug=<?php echo $post['slug']; ?>" class="lab-btn">Read More</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    <?php endforeach; ?>
<?php else: ?>
    <div class="alert alert-info">Belum ada postingan blog.</div>
<?php endif; ?>
