<?php
require_once 'auth_check.php';
include 'includes/header.php';
?>

<?php include 'includes/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header-wrapper">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div>
                <h1>
                    <i class="fas fa-images me-3"></i>Manage Banners
                </h1>
                <p class="text-muted mb-0 mt-2">Kelola gambar slider (Hero Section) pada halaman utama</p>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="add_banner.php" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Banner
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Data banner berhasil disimpan!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($_GET['status'] == 'deleted'): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Data banner berhasil dihapus!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($_GET['status'] == 'updated'): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Data banner berhasil diperbarui!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Banners Table -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 p-3 ps-4">Image</th>
                            <th class="border-0 p-3">Title & Subtitle</th>
                            <th class="border-0 p-3">Button</th>
                            <th class="border-0 p-3 text-center">Active</th>
                            <th class="border-0 p-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM banners ORDER BY order_index ASC, id DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $isActive = $row['is_active'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
                                ?>
                                <tr>
                                    <td class="p-3 ps-4" style="width: 150px;">
                                        <img src="../<?php echo htmlspecialchars($row['image']); ?>" alt="Banner" class="img-fluid rounded shadow-sm" style="height: 60px; object-fit: cover;">
                                    </td>
                                    <td class="p-3">
                                        <h6 class="mb-1 fw-bold"><?php echo htmlspecialchars($row['title']); ?></h6>
                                        <small class="text-muted d-block text-truncate" style="max-width: 300px;"><?php echo htmlspecialchars($row['subtitle']); ?></small>
                                    </td>
                                    <td class="p-3">
                                        <?php if (!empty($row['button_text'])): ?>
                                            <span class="badge bg-light text-dark border"><?php echo htmlspecialchars($row['button_text']); ?></span>
                                            <div class="small text-muted mt-1 text-truncate" style="max-width: 150px;"><?php echo htmlspecialchars($row['button_link']); ?></div>
                                        <?php else: ?>
                                            <span class="text-muted small">- No Button -</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-3 text-center">
                                        <?php echo $isActive; ?>
                                    </td>
                                    <td class="p-3 text-end pe-4">
                                        <div class="btn-group">
                                            <a href="edit_banner.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete(<?php echo $row['id']; ?>)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="5" class="text-center p-5 text-muted">Belum ada data banner. Silakan tambahkan banner baru.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Delete Confirmation Script -->
<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus banner ini?')) {
        window.location.href = 'delete_banner.php?id=' + id;
    }
}
</script>

<?php include 'includes/footer.php'; ?>
