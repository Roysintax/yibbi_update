<?php
require_once 'config/database.php';
include 'includes/header.php';
?>

<?php include 'includes/sidebar.php'; ?>

<main class="main-content">
<div class="page-header-wrapper">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div>
                <h1>
                    <i class="fas fa-home me-3"></i>Home Dashboard
                </h1>
                <p class="text-muted mb-0 mt-2">Kelola semua konten halaman utama website Anda</p>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-sync-alt me-2"></i>Refresh
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Alert -->
    <div class="alert alert-info d-flex align-items-center" role="alert">
        <i class="fas fa-info-circle me-3 fs-4"></i>
        <div>
            <strong>Selamat datang di Admin Dashboard!</strong>
            <p class="mb-0 mt-1">Anda dapat mengelola konten Halaman Utama (Home) yang tersimpan di database <strong>yibbi_db</strong>. Klik kartu di bawah untuk mulai mengedit konten.</p>
        </div>
    </div>

    <!-- Grid Cards untuk Konten Home -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
        
        <!-- Banners -->
        <div class="col">
            <div class="card h-100 border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-images me-2"></i> Banners (Hero Section)
                </div>
                <div class="card-body">
                    <?php
                    $sql = "SELECT COUNT(*) as count FROM banners WHERE is_active = 1";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $count = $row['count'];
                    ?>
                    <h5 class="card-title"><?php echo $count; ?> Active Banners</h5>
                    <p class="card-text">Kelola gambar slider, judul, dan tombol pada bagian atas halaman utama.</p>
                </div>
                <div class="card-footer bg-transparent border-primary">
                    <a href="manage_banners.php" class="btn btn-sm btn-primary w-100">Manage Banners</a>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <div class="col">
            <div class="card h-100 border-success">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-history me-2"></i> About Our History
                </div>
                <div class="card-body">
                     <?php
                    $sql = "SELECT heading FROM about_section LIMIT 1";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $heading = $row ? $row['heading'] : "Belum ada data";
                    ?>
                    <h5 class="card-title">History Content</h5>
                    <p class="card-text text-truncate">"<?php echo $heading; ?>"</p>
                    <p class="card-text"><small class="text-muted">Edit sejarah, visi, dan misi yayasan.</small></p>
                </div>
                <div class="card-footer bg-transparent border-success">
                    <a href="edit_about_history.php" class="btn btn-sm btn-success w-100">Edit History Content</a>
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="col">
            <div class="card h-100 border-warning">
                <div class="card-header bg-warning text-dark">
                    <i class="fas fa-star me-2"></i> Features & Services
                </div>
                <div class="card-body">
                    <?php
                    $sql = "SELECT COUNT(*) as count FROM features";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $count_features = $row['count'];
                    
                    $sql = "SELECT COUNT(*) as count FROM services";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $count_services = $row['count'];
                    ?>
                    <h5 class="card-title"><?php echo $count_features; ?> Features / <?php echo $count_services; ?> Services</h5>
                    <p class="card-text">Kelola poin-poin fitur utama dan daftar layanan yang ditampilkan.</p>
                </div>
                <div class="card-footer bg-transparent border-warning">
                    <a href="#" class="btn btn-sm btn-warning w-100 disabled">Manage Features (Coming Soon)</a>
                </div>
            </div>
        </div>

        <!-- Programs -->
        <div class="col">
            <div class="card h-100 border-info">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-hand-holding-heart me-2"></i> Programs (Donations)
                </div>
                <div class="card-body">
                    <?php
                    $sql = "SELECT COUNT(*) as count FROM programs";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $count = $row['count'];
                    ?>
                    <h5 class="card-title"><?php echo $count; ?> Programs Listed</h5>
                    <p class="card-text">Kelola kampanye donasi, target dana, dan progres donasi.</p>
                </div>
                <div class="card-footer bg-transparent border-info">
                    <a href="#" class="btn btn-sm btn-info text-white w-100 disabled">Manage Programs (Coming Soon)</a>
                </div>
            </div>
        </div>

        <!-- Faiths (Pillars) -->
        <div class="col">
            <div class="card h-100 border-secondary">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-kaaba me-2"></i> Faiths (Pillars of Islam)
                </div>
                <div class="card-body">
                     <?php
                    $sql = "SELECT COUNT(*) as count FROM faiths";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $count = $row['count'];
                    ?>
                    <h5 class="card-title"><?php echo $count; ?> Pillars Data</h5>
                    <p class="card-text">Edit konten tabulasi Rukun Islam (Syahadat, Sholat, Puasa, Zakat, Haji).</p>
                </div>
                <div class="card-footer bg-transparent border-secondary">
                    <a href="#" class="btn btn-sm btn-secondary w-100 disabled">Manage Faiths (Coming Soon)</a>
                </div>
            </div>
        </div>

        <!-- Events -->
        <div class="col">
            <div class="card h-100 border-danger">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-calendar-alt me-2"></i> Upcoming Events
                </div>
                <div class="card-body">
                    <?php
                    $sql = "SELECT COUNT(*) as count FROM events";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $count = $row['count'];
                    ?>
                    <h5 class="card-title"><?php echo $count; ?> Events Scheduled</h5>
                    <p class="card-text">Kelola jadwal acara, lokasi, dan gambar event.</p>
                </div>
                <div class="card-footer bg-transparent border-danger">
                    <a href="#" class="btn btn-sm btn-danger w-100 disabled">Manage Events (Coming Soon)</a>
                </div>
            </div>
        </div>

        <!-- Settings -->
         <div class="col">
            <div class="card h-100 border-dark">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-cogs me-2"></i> General Settings
                </div>
                <div class="card-body">
                    <?php
                    $sql = "SELECT site_title, phone, email FROM settings LIMIT 1";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    ?>
                    <ul class="list-unstyled">
                        <li><strong>Title:</strong> <?php echo $row['site_title']; ?></li>
                        <li><strong>Phone:</strong> <?php echo $row['phone']; ?></li>
                        <li><strong>Email:</strong> <?php echo $row['email']; ?></li>
                    </ul>
                    <p class="card-text">Pengaturan umum situs, logo, dan footer.</p>
                </div>
                <div class="card-footer bg-transparent border-dark">
                    <a href="#" class="btn btn-sm btn-dark w-100 disabled">Edit Settings (Coming Soon)</a>
                </div>
            </div>
        </div>

    </div>
</main>

<?php include 'includes/footer.php'; ?>
