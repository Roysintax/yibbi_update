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
                    <i class="fas fa-star me-3"></i>Manage Features
                </h1>
                <p class="text-muted mb-0 mt-2">Kelola Features section pada halaman utama</p>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addFeatureModal">
                    <i class="fas fa-plus me-2"></i>Add New Feature
                </button>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Data feature berhasil disimpan!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($_GET['status'] == 'deleted'): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Data feature berhasil dihapus!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($_GET['status'] == 'updated'): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Data feature berhasil diperbarui!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Features Table -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 p-3 ps-4">Image</th>
                            <th class="border-0 p-3">Title & Description</th>
                            <th class="border-0 p-3">Button</th>
                            <th class="border-0 p-3 text-center">Order</th>
                            <th class="border-0 p-3 text-center">Active</th>
                            <th class="border-0 p-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM features ORDER BY display_order ASC, id DESC");
                        $features = $stmt->fetchAll();

                        if (count($features) > 0) {
                            foreach($features as $feature) {
                                $isActive = $feature['is_active'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
                                ?>
                                <tr>
                                    <td class="p-3 ps-4" style="width: 120px;">
                                        <img src="../<?php echo htmlspecialchars($feature['image']); ?>" alt="Feature" class="img-fluid rounded shadow-sm" style="height: 60px; width: 60px; object-fit: cover;">
                                    </td>
                                    <td class="p-3">
                                        <h6 class="mb-1 fw-bold"><?php echo htmlspecialchars($feature['title']); ?></h6>
                                        <small class="text-muted d-block text-truncate" style="max-width: 350px;"><?php echo htmlspecialchars($feature['description']); ?></small>
                                    </td>
                                    <td class="p-3">
                                        <?php if (!empty($feature['button_text'])): ?>
                                            <span class="badge bg-light text-dark border"><?php echo htmlspecialchars($feature['button_text']); ?></span>
                                            <div class="small text-muted mt-1 text-truncate" style="max-width: 150px;"><?php echo htmlspecialchars($feature['button_link']); ?></div>
                                        <?php else: ?>
                                            <span class="text-muted small">- No Button -</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-3 text-center">
                                        <span class="badge bg-primary"><?php echo $feature['display_order']; ?></span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <?php echo $isActive; ?>
                                    </td>
                                    <td class="p-3 text-end pe-4">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Edit" onclick="editFeature(<?php echo $feature['id']; ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete(<?php echo $feature['id']; ?>)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="6" class="text-center p-5 text-muted">Belum ada data feature. Silakan tambahkan feature baru.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Add Feature Modal -->
<div class="modal fade" id="addFeatureModal" tabindex="-1" aria-labelledby="addFeatureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFeatureModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Add New Feature
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addFeatureForm" action="process_feature.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="button_text" class="form-label">Button Text</label>
                                <input type="text" class="form-control" id="button_text" name="button_text" placeholder="Read More">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="button_link" class="form-label">Button Link</label>
                                <input type="text" class="form-control" id="button_link" name="button_link" placeholder="#" value="#">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="display_order" class="form-label">Display Order</label>
                                <input type="number" class="form-control" id="display_order" name="display_order" value="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="is_active" class="form-label">Status</label>
                                <select class="form-select" id="is_active" name="is_active">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Icon Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        <small class="text-muted">Recommended size: 100x100 px (Icon)</small>
                    </div>
                    <input type="hidden" name="cropped_image" id="cropped_image">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Feature
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Feature Modal -->
<div class="modal fade" id="editFeatureModal" tabindex="-1" aria-labelledby="editFeatureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFeatureModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Feature
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFeatureForm" action="process_feature.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_title" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_button_text" class="form-label">Button Text</label>
                                <input type="text" class="form-control" id="edit_button_text" name="button_text">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_button_link" class="form-label">Button Link</label>
                                <input type="text" class="form-control" id="edit_button_link" name="button_link">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="edit_display_order" class="form-label">Display Order</label>
                                <input type="number" class="form-control" id="edit_display_order" name="display_order">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="edit_is_active" class="form-label">Status</label>
                                <select class="form-select" id="edit_is_active" name="is_active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Current Icon</label>
                        <div>
                            <img id="edit_current_image" src="" alt="Current Icon" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Change Icon (Optional)</label>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                        <small class="text-muted">Leave empty to keep current icon</small>
                    </div>
                    <input type="hidden" name="cropped_image" id="edit_cropped_image">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Feature
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
function editFeature(id) {
    // Fetch feature data using AJAX
    fetch('get_feature.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_title').value = data.title;
            document.getElementById('edit_description').value = data.description;
            document.getElementById('edit_button_text').value = data.button_text;
            document.getElementById('edit_button_link').value = data.button_link;
            document.getElementById('edit_display_order').value = data.display_order;
            document.getElementById('edit_is_active').value = data.is_active;
            document.getElementById('edit_current_image').src = '../' + data.image;
            
            // Show modal
            new bootstrap.Modal(document.getElementById('editFeatureModal')).show();
        });
}

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus feature ini?')) {
        window.location.href = 'delete_feature.php?id=' + id;
    }
}

// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});
</script>

<?php include 'includes/footer.php'; ?>
