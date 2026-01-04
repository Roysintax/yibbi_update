    <!-- Faith Section -->
    <section class="faith-section padding-tb shape-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-title">
                        <h5>The Pillars of Islam</h5>
                        <h2>Ethical And Moral Beliefs That Guides To The Straight Path!</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="faith-content">
                        <div class="tab-content" id="pills-tabContent">
                            <?php foreach ($faiths as $index => $faith): ?>
                            <div class="tab-pane fade <?php echo $index === 0 ? 'show active' : ''; ?>" id="faith-<?php echo $faith['id']; ?>" role="tabpanel">
                                <div class="lab-item faith-item tri-shape-1 pattern-2">
                                    <div class="lab-inner d-flex align-items-center">
                                        <div class="lab-thumb">
                                            <img src="<?php echo htmlspecialchars($faith['icon']); ?>" alt="faith-image">
                                        </div>
                                        <div class="lab-content">
                                            <h4><?php echo htmlspecialchars($faith['title']); ?></h4>
                                            <p><?php echo htmlspecialchars($faith['description']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <ul class="nav nav-pills mb-3 align-items-center justify-content-center" id="pills-tab" role="tablist">
                            <?php foreach ($faiths as $index => $faith): ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>" id="faith-tab-<?php echo $faith['id']; ?>" data-bs-toggle="pill" href="#faith-<?php echo $faith['id']; ?>" role="tab">
                                    <img src="<?php echo htmlspecialchars($faith['icon']); ?>" alt="faith-icon">
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
