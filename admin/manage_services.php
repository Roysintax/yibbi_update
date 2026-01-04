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
                    <i class="fas fa-hands-helping me-3"></i>Manage Services
                </h1>
                <p class="text-muted mb-0 mt-2">Kelola Services section pada halaman utama</p>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                    <i class="fas fa-plus me-2"></i>Add New Service
                </button>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Data service berhasil disimpan!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($_GET['status'] == 'deleted'): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Data service berhasil dihapus!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($_GET['status'] == 'updated'): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Data service berhasil diperbarui!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Services Table -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 p-3 ps-4">Main Image</th>
                            <th class="border-0 p-3">Icon</th>
                            <th class="border-0 p-3">Title & Info</th>
                            <th class="border-0 p-3 text-center">Order</th>
                            <th class="border-0 p-3 text-center">Active</th>
                            <th class="border-0 p-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM services ORDER BY display_order ASC, id DESC");
                        $services = $stmt->fetchAll();

                        if (count($services) > 0) {
                            foreach($services as $service) {
                                $isActive = $service['is_active'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
                                ?>
                                <tr>
                                    <td class="p-3 ps-4" style="width: 150px;">
                                        <img src="../<?php echo htmlspecialchars($service['image']); ?>" alt="Service" class="img-fluid rounded shadow-sm" style="height: 80px; object-fit: cover;">
                                    </td>
                                    <td class="p-3" style="width: 80px;">
                                        <img src="../<?php echo htmlspecialchars($service['icon']); ?>" alt="Icon" class="img-fluid rounded" style="height: 50px; width: 50px; object-fit: contain;">
                                    </td>
                                    <td class="p-3">
                                        <h6 class="mb-1 fw-bold"><?php echo htmlspecialchars($service['title']); ?></h6>
                                        <small class="text-primary d-block"><?php echo htmlspecialchars($service['subtitle']); ?></small>
                                        <small class="text-muted d-block text-truncate mt-1" style="max-width: 300px;"><?php echo htmlspecialchars($service['description']); ?></small>
                                    </td>
                                    <td class="p-3 text-center">
                                        <span class="badge bg-primary"><?php echo $service['display_order']; ?></span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <?php echo $isActive; ?>
                                    </td>
                                    <td class="p-3 text-end pe-4">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Edit" onclick="editService(<?php echo $service['id']; ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete(<?php echo $service['id']; ?>)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="6" class="text-center p-5 text-muted">Belum ada data service. Silakan tambahkan service baru.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Add New Service
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addServiceForm" action="process_service.php" method="POST">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="cropped_main_image" id="croppedMainImageData">
                <input type="hidden" name="cropped_icon" id="croppedIconData">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="subtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Listen Our Imam Leader">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="display_order" class="form-label">Display Order</label>
                                    <input type="number" class="form-control" id="display_order" name="display_order" value="0">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="is_active" class="form-label">Status</label>
                                    <select class="form-select" id="is_active" name="is_active">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <!-- Main Image Upload -->
                            <div class="mb-4">
                                <label class="form-label">Main Image (390x249px) <span class="text-danger">*</span></label>
                                <div class="image-upload-wrapper text-center">
                                    <div class="current-image-preview mb-2">
                                        <img src="../assets/images/no-image.png" id="previewMainImg" alt="Preview" class="img-fluid rounded" style="max-height: 120px; display: none;">
                                        <div id="placeholderMainImg" class="py-4 text-muted bg-light rounded border">
                                            <i class="fas fa-image fa-2x mb-2 text-secondary"></i>
                                            <p class="mb-0 small">No image</p>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm w-100" id="uploadMainTrigger">
                                        <i class="fas fa-cloud-upload-alt me-1"></i>Choose Image
                                    </button>
                                    <input type="file" id="mainImageUpload" accept="image/*" style="display: none;">
                                </div>
                            </div>
                            
                            <!-- Icon Upload -->
                            <div class="mb-3">
                                <label class="form-label">Icon (50x50px) <span class="text-danger">*</span></label>
                                <div class="image-upload-wrapper text-center">
                                    <div class="current-image-preview mb-2">
                                        <img src="../assets/images/no-image.png" id="previewIconImg" alt="Preview" class="img-fluid rounded" style="max-height: 80px; display: none;">
                                        <div id="placeholderIconImg" class="py-3 text-muted bg-light rounded border">
                                            <i class="fas fa-image fa-2x mb-1 text-secondary"></i>
                                            <p class="mb-0 small">No icon</p>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm w-100" id="uploadIconTrigger">
                                        <i class="fas fa-cloud-upload-alt me-1"></i>Choose Icon
                                    </button>
                                    <input type="file" id="iconUpload" accept="image/*" style="display: none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Service
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Service Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editServiceModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Service
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editServiceForm" action="process_service.php" method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                <input type="hidden" name="cropped_main_image" id="editCroppedMainImageData">
                <input type="hidden" name="cropped_icon" id="editCroppedIconData">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_title" name="title" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_subtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" id="edit_subtitle" name="subtitle">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_display_order" class="form-label">Display Order</label>
                                    <input type="number" class="form-control" id="edit_display_order" name="display_order">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_is_active" class="form-label">Status</label>
                                    <select class="form-select" id="edit_is_active" name="is_active">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <!-- Edit Main Image -->
                            <div class="mb-4">
                                <label class="form-label">Main Image (390x249px)</label>
                                <div class="image-upload-wrapper text-center">
                                    <div class="current-image-preview mb-2">
                                        <img id="edit_current_main_image" src="" alt="Current Image" class="img-fluid rounded" style="max-height: 120px;">
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm w-100" id="editUploadMainTrigger">
                                        <i class="fas fa-cloud-upload-alt me-1"></i>Change Image
                                    </button>
                                    <input type="file" id="editMainImageUpload" accept="image/*" style="display: none;">
                                    <small class="text-muted d-block mt-1">Leave empty to keep current</small>
                                </div>
                            </div>
                            
                            <!-- Edit Icon -->
                            <div class="mb-3">
                                <label class="form-label">Icon (50x50px)</label>
                                <div class="image-upload-wrapper text-center">
                                    <div class="current-image-preview mb-2">
                                        <img id="edit_current_icon" src="" alt="Current Icon" class="img-fluid rounded" style="max-height: 80px;">
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm w-100" id="editUploadIconTrigger">
                                        <i class="fas fa-cloud-upload-alt me-1"></i>Change Icon
                                    </button>
                                    <input type="file" id="editIconUpload" accept="image/*" style="display: none;">
                                    <small class="text-muted d-block mt-1">Leave empty to keep current</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Service
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Crop Modal for Main Image -->
<div class="modal fade" id="cropMainImageModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Main Image (390x249px)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 bg-dark">
                <div style="height: 500px; position: relative;">
                    <cropper-canvas id="cropperCanvasMain" background style="width: 100%; height: 100%;">
                        <cropper-image id="cropperImageMain" rotatable scalable zoomable translatable></cropper-image>
                        <cropper-shade hidden></cropper-shade>
                        <cropper-handle action="select" plain></cropper-handle>
                        <cropper-selection id="cropperSelectionMain" initial-coverage="0.8" movable resizable outlined zoomable>
                            <cropper-grid role="grid" bordered covered></cropper-grid>
                            <cropper-crosshair centered></cropper-crosshair>
                            <cropper-handle action="move" theme-color="rgba(255, 255, 255, 0.35)"></cropper-handle>
                            <cropper-handle action="n-resize"></cropper-handle>
                            <cropper-handle action="e-resize"></cropper-handle>
                            <cropper-handle action="s-resize"></cropper-handle>
                            <cropper-handle action="w-resize"></cropper-handle>
                            <cropper-handle action="ne-resize"></cropper-handle>
                            <cropper-handle action="nw-resize"></cropper-handle>
                            <cropper-handle action="se-resize"></cropper-handle>
                            <cropper-handle action="sw-resize"></cropper-handle>
                        </cropper-selection>
                    </cropper-canvas>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" id="zoomOutMain"><i class="fas fa-search-minus"></i></button>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="zoomInMain"><i class="fas fa-search-plus"></i></button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="cropMainButton"><i class="fas fa-crop me-1"></i>Crop</button>
            </div>
        </div>
    </div>
</div>

<!-- Crop Modal for Icon -->
<div class="modal fade" id="cropIconModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Icon (50x50px)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 bg-dark">
                <div style="height: 500px; position: relative;">
                    <cropper-canvas id="cropperCanvasIcon" background style="width: 100%; height: 100%;">
                        <cropper-image id="cropperImageIcon" rotatable scalable zoomable translatable></cropper-image>
                        <cropper-shade hidden></cropper-shade>
                        <cropper-handle action="select" plain></cropper-handle>
                        <cropper-selection id="cropperSelectionIcon" initial-coverage="0.8" movable resizable outlined zoomable>
                            <cropper-grid role="grid" bordered covered></cropper-grid>
                            <cropper-crosshair centered></cropper-crosshair>
                            <cropper-handle action="move" theme-color="rgba(255, 255, 255, 0.35)"></cropper-handle>
                            <cropper-handle action="n-resize"></cropper-handle>
                            <cropper-handle action="e-resize"></cropper-handle>
                            <cropper-handle action="s-resize"></cropper-handle>
                            <cropper-handle action="w-resize"></cropper-handle>
                            <cropper-handle action="ne-resize"></cropper-handle>
                            <cropper-handle action="nw-resize"></cropper-handle>
                            <cropper-handle action="se-resize"></cropper-handle>
                            <cropper-handle action="sw-resize"></cropper-handle>
                        </cropper-selection>
                    </cropper-canvas>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" id="zoomOutIcon"><i class="fas fa-search-minus"></i></button>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="zoomInIcon"><i class="fas fa-search-plus"></i></button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="cropIconButton"><i class="fas fa-crop me-1"></i>Crop</button>
            </div>
        </div>
    </div>
</div>

<!-- Cropper.js 2.0 (Web Component) -->
<script src="assets/js/cropper.min.js"></script>

<?php include 'includes/footer.php'; ?>

<script>
// Global variables
let currentEditMode = false;

// Wait for page to fully load
document.addEventListener('DOMContentLoaded', function() {
    initializeMainImageUploader();
    initializeIconUploader();
    initializeTooltips();
});

// Main Image Uploader
function initializeMainImageUploader() {
    const uploadTrigger = document.getElementById('uploadMainTrigger');
    const imageUpload = document.getElementById('mainImageUpload');
    const editUploadTrigger = document.getElementById('editUploadMainTrigger');
    const editImageUpload = document.getElementById('editMainImageUpload');
    
    if (uploadTrigger) {
        uploadTrigger.addEventListener('click', () => imageUpload.click());
    }
    
    if (editUploadTrigger) {
        editUploadTrigger.addEventListener('click', () => {
            currentEditMode = true;
            editImageUpload.click();
        });
    }
    
    if (imageUpload) {
        imageUpload.addEventListener('change', (e) => handleMainImageSelection(e, false));
    }
    
    if (editImageUpload) {
        editImageUpload.addEventListener('change', (e) => handleMainImageSelection(e, true));
    }
}

function handleMainImageSelection(e, isEdit) {
    const file = e.target.files[0];
    if (!file || !file.type.match('image.*')) {
        alert('Hanya file gambar yang diperbolehkan!');
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(event) {
        const cropperImage = document.getElementById('cropperImageMain');
        const cropperSelection = document.getElementById('cropperSelectionMain');
        
        cropperImage.src = event.target.result;
        
        setTimeout(() => {
            cropperImage.$center('contain');
            cropperSelection.setAttribute('aspect-ratio', 390 / 249);
            cropperSelection.$center('contain');
        }, 100);
        
        const modal = new bootstrap.Modal(document.getElementById('cropMainImageModal'));
        modal.show();
        
        currentEditMode = isEdit;
    };
    reader.readAsDataURL(file);
}

// Icon Uploader
function initializeIconUploader() {
    const uploadTrigger = document.getElementById('uploadIconTrigger');
    const imageUpload = document.getElementById('iconUpload');
    const editUploadTrigger = document.getElementById('editUploadIconTrigger');
    const editImageUpload = document.getElementById('editIconUpload');
    
    if (uploadTrigger) {
        uploadTrigger.addEventListener('click', () => imageUpload.click());
    }
    
    if (editUploadTrigger) {
        editUploadTrigger.addEventListener('click', () => {
            currentEditMode = true;
            editImageUpload.click();
        });
    }
    
    if (imageUpload) {
        imageUpload.addEventListener('change', (e) => handleIconSelection(e, false));
    }
    
    if (editImageUpload) {
        editImageUpload.addEventListener('change', (e) => handleIconSelection(e, true));
    }
}

function handleIconSelection(e, isEdit) {
    const file = e.target.files[0];
    if (!file || !file.type.match('image.*')) {
        alert('Hanya file gambar yang diperbolehkan!');
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(event) {
        const cropperImage = document.getElementById('cropperImageIcon');
        const cropperSelection = document.getElementById('cropperSelectionIcon');
        
        cropperImage.src = event.target.result;
        
        setTimeout(() => {
            cropperImage.$center('contain');
            cropperSelection.setAttribute('aspect-ratio', 1);
            cropperSelection.$center('contain');
        }, 100);
        
        const modal = new bootstrap.Modal(document.getElementById('cropIconModal'));
        modal.show();
        
        currentEditMode = isEdit;
    };
    reader.readAsDataURL(file);
}

// Crop Main Image
document.getElementById('cropMainButton')?.addEventListener('click', async function() {
    const cropperSelection = document.getElementById('cropperSelectionMain');
    if (cropperSelection) {
        try {
            const canvas = await cropperSelection.$toCanvas({
                width: 390,
                height: 249,
                fillColor: '#fff'
            });
            
            const base64 = canvas.toDataURL('image/png');
            
            if (currentEditMode) {
                document.getElementById('editCroppedMainImageData').value = base64;
                document.getElementById('edit_current_main_image').src = base64;
            } else {
                document.getElementById('croppedMainImageData').value = base64;
                document.getElementById('previewMainImg').src = base64;
                document.getElementById('previewMainImg').style.display = 'block';
                document.getElementById('placeholderMainImg').style.display = 'none';
            }
            
            bootstrap.Modal.getInstance(document.getElementById('cropMainImageModal')).hide();
        } catch (error) {
            console.error('Error cropping:', error);
            alert('Terjadi kesalahan saat memotong gambar.');
        }
    }
});

// Crop Icon
document.getElementById('cropIconButton')?.addEventListener('click', async function() {
    const cropperSelection = document.getElementById('cropperSelectionIcon');
    if (cropperSelection) {
        try {
            const canvas = await cropperSelection.$toCanvas({
                width: 50,
                height: 50,
                fillColor: '#fff'
            });
            
            const base64 = canvas.toDataURL('image/png');
            
            if (currentEditMode) {
                document.getElementById('editCroppedIconData').value = base64;
                document.getElementById('edit_current_icon').src = base64;
            } else {
                document.getElementById('croppedIconData').value = base64;
                document.getElementById('previewIconImg').src = base64;
                document.getElementById('previewIconImg').style.display = 'block';
                document.getElementById('placeholderIconImg').style.display = 'none';
            }
            
            bootstrap.Modal.getInstance(document.getElementById('cropIconModal')).hide();
        } catch (error) {
            console.error('Error cropping:', error);
            alert('Terjadi kesalahan saat memotong gambar.');
        }
    }
});

// Zoom controls
document.getElementById('zoomInMain')?.addEventListener('click', () => {
    document.getElementById('cropperImageMain')?.$zoom(0.1);
});

document.getElementById('zoomOutMain')?.addEventListener('click', () => {
    document.getElementById('cropperImageMain')?.$zoom(-0.1);
});

document.getElementById('zoomInIcon')?.addEventListener('click', () => {
    document.getElementById('cropperImageIcon')?.$zoom(0.1);
});

document.getElementById('zoomOutIcon')?.addEventListener('click', () => {
    document.getElementById('cropperImageIcon')?.$zoom(-0.1);
});

// Edit Service
function editService(id) {
    fetch('get_service.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_title').value = data.title;
            document.getElementById('edit_subtitle').value = data.subtitle;
            document.getElementById('edit_description').value = data.description;
            document.getElementById('edit_display_order').value = data.display_order;
            document.getElementById('edit_is_active').value = data.is_active;
            document.getElementById('edit_current_main_image').src = '../' + data.image;
            document.getElementById('edit_current_icon').src = '../' + data.icon;
            document.getElementById('editCroppedMainImageData').value = '';
            document.getElementById('editCroppedIconData').value = '';
            
            new bootstrap.Modal(document.getElementById('editServiceModal')).show();
        });
}

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus service ini?')) {
        window.location.href = 'delete_service.php?id=' + id;
    }
}

function initializeTooltips() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}
</script>
