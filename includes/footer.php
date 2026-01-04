    <!-- Bagian Footer Dimulai Di Sini -->
    <footer class="footer-section" style="background-image: url(<?php echo BASE_URL; ?>assets/images/bg-images/footer-bg.png);">
        <!-- Footer Atas: Info Kontak Cepat -->
        <div class="footer-top">
            <div class="container">
                <div class="row g-3 justify-content-center g-lg-0">
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="footer-top-item lab-item">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="<?php echo BASE_URL; ?>assets/images/footer/footer-top/01.png" alt="Phone-icon">
                                </div>
                                <div class="lab-content">
                                    <span>Phone Number : <?php echo htmlspecialchars($settings['phone'] ?? '+88019 339 702 520'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="footer-top-item lab-item">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="<?php echo BASE_URL; ?>assets/images/footer/footer-top/02.png" alt="email-icon">
                                </div>
                                <div class="lab-content">
                                    <span>Email : <?php echo htmlspecialchars($settings['email'] ?? 'admin@YIBBI.com'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="footer-top-item lab-item">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="<?php echo BASE_URL; ?>assets/images/footer/footer-top/03.png" alt="location-icon">
                                </div>
                                <div class="lab-content">
                                    <span>Address : <?php echo htmlspecialchars($settings['address'] ?? '30 North West New York 240'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Tengah: Widget -->
        <div class="footer-middle padding-tb tri-shape-3">
            <div class="container">
                <div class="row">
                    <!-- Widget 1: Tentang YIBBI -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="footer-middle-item-wrapper">
                            <div class="footer-middle-item mb-5 mb-lg-0">
                                <div class="fm-item-title">
                                    <h5><?php echo htmlspecialchars($settings['footer_about_title'] ?? 'About YIBBI'); ?></h5>
                                </div>
                                <div class="fm-item-content">
                                    <p class="mb-4"><?php echo htmlspecialchars($settings['footer_about_text'] ?? 'Energistically coordinate highly efficient procesr partnerships befor revolutionar growth strategie improvement'); ?></p>
                                    <img src="<?php echo BASE_URL; ?><?php echo htmlspecialchars($settings['footer_about_image'] ?? 'assets/images/footer/footer-middle/01.jpg'); ?>" alt="about-image"
                                        class="footer-abt-img">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Widget 2: Berita Terbaru -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="footer-middle-item-wrapper">
                            <div class="footer-middle-item mb-5 mb-lg-0">
                                <div class="fm-item-title">
                                    <h5>our Recent news</h5>
                                </div>
                                <div class="fm-item-content">
                                    <div class="fm-item-widget lab-item">
                                        <div class="lab-inner">
                                            <div class="lab-thumb">
                                                <a href="#"> <img src="<?php echo BASE_URL; ?>assets/images/footer/footer-middle/02.jpg"
                                                        alt="footer-widget-img"></a>
                                            </div>
                                            <div class="lab-content">
                                                <h6><a href="#">Enable Seamin Matera Forin And Our
                                                        Orthonal Create Vortals.</a></h6>
                                                <p>July 23, 2021</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fm-item-widget lab-item">
                                        <div class="lab-inner">
                                            <div class="lab-thumb">
                                                <a href="#"><img src="<?php echo BASE_URL; ?>assets/images/footer/footer-middle/03.jpg"
                                                        alt="footer-widget-img"></a>
                                            </div>
                                            <div class="lab-content">
                                                <h6><a href="#">Dynamca Network Otuitive Catays For
                                                        Plagiarize Mindshare After</a></h6>
                                                <p>July 23, 2021</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Widget 3: Newsletter -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="footer-middle-item-wrapper">
                            <div class="footer-middle-item-3 mb-5 mb-lg-0">
                                <div class="fm-item-title">
                                    <h5>OUR NEWSLETTER</h5>
                                </div>
                                <div class="fm-item-content">
                                    <p><?php echo htmlspecialchars($settings['site_title'] ?? 'YIBBI'); ?> is a nonproﬁt organization supported
                                        by community leaders</p>
                                    <form>
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Enter email">
                                        </div>
                                        <button type="submit" class="lab-btn">Send Massage <i
                                                class="icofont-paper-plane"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Bawah: Copyright -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="footer-bottom-content text-center">
                            <p>&copy;<?php echo date('Y'); ?> <a href="index.php">YIBBI</a> - Yayasan Indonesia Bijak Bestari</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bagian Footer Berakhir Di Sini -->



    <!-- Tombol Scroll ke Atas -->
    <a href="#" class="scrollToTop"><i class="icofont-bubble-up"></i><span class="pluse_1"></span><span
            class="pluse_2"></span></a>
    <!-- Scroll ke Atas Berakhir Di Sini -->


    <!-- Script JavaScript -->
    <script src="<?php echo BASE_URL; ?>assets/js/jquery.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/fontawesome.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/waypoints.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/swiper.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/circularProgressBar.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/isotope.pkgd.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/lightcase.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/functions.js"></script>
</body>

</html>
