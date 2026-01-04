<?php
require_once 'auth_check.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$message = "";
$error = "";

// Create uploads directory if not exists
$uploadDir = '../assets/images/about/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = 1; // Assuming we are editing the first/only record
    $title = $conn->real_escape_string($_POST['title']);
    $subtitle = $conn->real_escape_string($_POST['subtitle']);
    $achievements_title = $conn->real_escape_string($_POST['achievements_title']);
    $description = $conn->real_escape_string($_POST['description']);
    
    // Handle cropped image upload
    $image = isset($_POST['current_image']) ? $_POST['current_image'] : '';
    
    if (!empty($_POST['cropped_image'])) {
        // Decode base64 image
        $croppedImage = $_POST['cropped_image'];
        $croppedImage = str_replace('data:image/png;base64,', '', $croppedImage);
        $croppedImage = str_replace('data:image/jpeg;base64,', '', $croppedImage);
        $croppedImage = str_replace(' ', '+', $croppedImage);
        $imageData = base64_decode($croppedImage);
        
        // Generate unique filename
        $filename = 'about_' . time() . '.png';
        $filepath = $uploadDir . $filename;
        
        // Save the image
        if (file_put_contents($filepath, $imageData)) {
            $image = 'assets/images/about/' . $filename;
        } else {
            $error = "Failed to save image";
        }
    }
    
    if (empty($error)) {
        $sql = "UPDATE about_history SET 
                title='$title', 
                subtitle='$subtitle', 
                description='$description', 
                achievements_title='$achievements_title',
                image='$image'
                WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            $message = "Record updated successfully";
        } else {
            $error = "Error updating record: " . $conn->error;
        }
    }
}

// Fetch Data
$sql = "SELECT * FROM about_history WHERE id=1";
$result = $conn->query($sql);
$data = $result->fetch_assoc();
?>

<main class="main-content">
    <div class="page-header-wrapper">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div>
                <h1>
                    <i class="fas fa-history me-3"></i>Edit About History
                </h1>
                <p class="text-muted mb-0 mt-2">Update konten sejarah dan profil yayasan</p>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="index.php" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="" id="aboutForm">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Title (Main)</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($data['title']) ? htmlspecialchars($data['title']) : ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="subtitle" class="form-label">Subtitle (Small/Date)</label>
                        <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?php echo isset($data['subtitle']) ? htmlspecialchars($data['subtitle']) : ''; ?>">
                    </div>
                    
                    <div class="col-12">
                         <label for="achievements_title" class="form-label">Achievements Title</label>
                        <input type="text" class="form-control" id="achievements_title" name="achievements_title" value="<?php echo isset($data['achievements_title']) ? htmlspecialchars($data['achievements_title']) : ''; ?>">
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required><?php echo isset($data['description']) ? htmlspecialchars($data['description']) : ''; ?></textarea>
                    </div>

                    <!-- Image Upload Section -->
                    <div class="col-12">
                        <label class="form-label">Section Image</label>
                        <div class="image-upload-wrapper">
                            <!-- Current Image Preview -->
                            <div class="current-image-preview mb-3">
                                <p class="text-muted small mb-2">Gambar Saat Ini:</p>
                                <?php if (!empty($data['image'])): ?>
                                    <img src="../<?php echo htmlspecialchars($data['image']); ?>" alt="Current Image" class="img-thumbnail" style="max-height: 150px;">
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada gambar</span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Upload New Image -->
                            <div class="upload-section">
                                <div class="upload-label" id="uploadTrigger">
                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                    <span>Klik untuk upload gambar baru</span>
                                    <small class="text-muted d-block">Format: JPG, PNG, GIF</small>
                                </div>
                                <input type="file" id="imageUpload" accept="image/*" style="display: none;">
                            </div>
                            
                            <!-- Hidden inputs for form submission -->
                            <input type="hidden" name="current_image" value="<?php echo isset($data['image']) ? htmlspecialchars($data['image']) : ''; ?>">
                            <input type="hidden" name="cropped_image" id="croppedImageData">
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Image Cropper Modal -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropperModalLabel">
                    <i class="fas fa-crop-alt me-2"></i>Adjust & Crop Image
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="cropper-container">
                    <img id="cropperImage" src="" alt="Crop Image">
                </div>
                <div class="cropper-controls mt-3">
                    <div class="btn-group me-2" role="group">
                        <button type="button" class="btn btn-outline-secondary" id="rotateLeft" title="Rotate Left">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="rotateRight" title="Rotate Right">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                    <div class="btn-group me-2" role="group">
                        <button type="button" class="btn btn-outline-secondary" id="zoomIn" title="Zoom In">
                            <i class="fas fa-search-plus"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="zoomOut" title="Zoom Out">
                            <i class="fas fa-search-minus"></i>
                        </button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary" id="flipH" title="Flip Horizontal">
                            <i class="fas fa-arrows-alt-h"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="flipV" title="Flip Vertical">
                            <i class="fas fa-arrows-alt-v"></i>
                        </button>
                    </div>
                    <button type="button" class="btn btn-outline-secondary ms-2" id="resetCrop" title="Reset">
                        <i class="fas fa-sync-alt"></i> Reset
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" id="applyCrop">
                    <i class="fas fa-check me-1"></i>Apply Crop
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cropper.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">

<!-- RichTextEditor CSS -->
<link rel="stylesheet" href="richtexteditor/rte_theme_default.css" />

<script>
// Wait for page to fully load before initializing
document.addEventListener('DOMContentLoaded', function() {
    // Initialize RichTextEditor after a short delay to ensure it's loaded
    setTimeout(function() {
        if (typeof RichTextEditor !== 'undefined') {
            var editor1 = new RichTextEditor("#description", {
                contentCssUrl: "richtexteditor/runtime/richtexteditor_content.css"
            });
        }
    }, 100);
    
    // Image Cropper Variables
    let cropper = null;
    const uploadTrigger = document.getElementById('uploadTrigger');
    const imageUpload = document.getElementById('imageUpload');
    const cropperImage = document.getElementById('cropperImage');
    const croppedImageData = document.getElementById('croppedImageData');
    let cropperModal = null;
    
    // Initialize modal after Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));
    }
    
    // Click handler for upload trigger
    if (uploadTrigger) {
        uploadTrigger.addEventListener('click', function() {
            imageUpload.click();
        });
    }
    
    // Handle file selection
    if (imageUpload) {
        imageUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file type only (no size limit)
                if (!file.type.match('image.*')) {
                    alert('Hanya file gambar yang diperbolehkan!');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(event) {
                    cropperImage.src = event.target.result;
                    
                    // Initialize modal if not already done
                    if (!cropperModal && typeof bootstrap !== 'undefined') {
                        cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));
                    }
                    
                    if (cropperModal) {
                        cropperModal.show();
                    }
                    
                    // Initialize cropper after modal is shown
                    document.getElementById('cropperModal').addEventListener('shown.bs.modal', function() {
                        if (cropper) {
                            cropper.destroy();
                        }
                        if (typeof Cropper !== 'undefined') {
                            cropper = new Cropper(cropperImage, {
                                aspectRatio: 1, // Circle requires 1:1 aspect ratio
                                viewMode: 1,
                                autoCropArea: 0.9,
                                responsive: true,
                                guides: true,
                                center: true,
                                highlight: true,
                                background: true
                            });
                        }
                    }, { once: true });
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Add CSS for Circular Crop View
    const style = document.createElement('style');
    style.innerHTML = `
        .cropper-view-box,
        .cropper-face {
            border-radius: 50%;
        }
    `;
    document.head.appendChild(style);
    
    // Rotate Left
    const rotateLeftBtn = document.getElementById('rotateLeft');
    if (rotateLeftBtn) {
        rotateLeftBtn.addEventListener('click', function() {
            if (cropper) cropper.rotate(-45);
        });
    }
    
    // Rotate Right
    const rotateRightBtn = document.getElementById('rotateRight');
    if (rotateRightBtn) {
        rotateRightBtn.addEventListener('click', function() {
            if (cropper) cropper.rotate(45);
        });
    }
    
    // Zoom In
    const zoomInBtn = document.getElementById('zoomIn');
    if (zoomInBtn) {
        zoomInBtn.addEventListener('click', function() {
            if (cropper) cropper.zoom(0.1);
        });
    }
    
    // Zoom Out
    const zoomOutBtn = document.getElementById('zoomOut');
    if (zoomOutBtn) {
        zoomOutBtn.addEventListener('click', function() {
            if (cropper) cropper.zoom(-0.1);
        });
    }
    
    // Flip Horizontal
    const flipHBtn = document.getElementById('flipH');
    if (flipHBtn) {
        flipHBtn.addEventListener('click', function() {
            if (cropper) {
                const data = cropper.getData();
                cropper.scaleX(-data.scaleX || -1);
            }
        });
    }
    
    // Flip Vertical
    const flipVBtn = document.getElementById('flipV');
    if (flipVBtn) {
        flipVBtn.addEventListener('click', function() {
            if (cropper) {
                const data = cropper.getData();
                cropper.scaleY(-data.scaleY || -1);
            }
        });
    }
    
    // Reset Crop
    const resetCropBtn = document.getElementById('resetCrop');
    if (resetCropBtn) {
        resetCropBtn.addEventListener('click', function() {
            if (cropper) cropper.reset();
        });
    }
    
    // Apply Crop
    const applyCropBtn = document.getElementById('applyCrop');
    if (applyCropBtn) {
        applyCropBtn.addEventListener('click', function() {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas({
                    width: 500,
                    height: 500
                });
                
                // Convert to base64
                const base64 = canvas.toDataURL('image/png');
                croppedImageData.value = base64;
                
                // Update preview
                const previewContainer = document.querySelector('.current-image-preview');
                previewContainer.innerHTML = `
                    <p class="text-muted small mb-2">Gambar Baru (akan disimpan):</p>
                    <img src="${base64}" alt="Cropped Preview" class="img-thumbnail" style="max-height: 150px;">
                    <span class="badge bg-success ms-2">Ready to save</span>
                `;
                
                // Close modal
                if (cropperModal) {
                    cropperModal.hide();
                }
                
                // Reset file input
                imageUpload.value = '';
            }
        });
    }
    
    // Cleanup cropper when modal is hidden
    const cropperModalEl = document.getElementById('cropperModal');
    if (cropperModalEl) {
        cropperModalEl.addEventListener('hidden.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });
    }
});
</script>

<style>
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
    }
    .form-label {
        font-weight: 500;
        color: #4a5568;
    }
    
    /* Image Upload Styles */
    .image-upload-wrapper {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        padding: 20px;
    }
    
    .upload-section {
        text-align: center;
    }
    
    .upload-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        cursor: pointer;
        padding: 30px;
        border: 2px dashed #667eea;
        border-radius: 10px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        transition: all 0.3s ease;
    }
    
    .upload-label:hover {
        background: linear-gradient(135deg, #e8ecf5 0%, #b5c4dd 100%);
        border-color: #5a67d8;
        transform: translateY(-2px);
    }
    
    .upload-label i {
        color: #667eea;
    }
    
    .current-image-preview img {
        border: 3px solid #28a745;
        border-radius: 8px;
    }
    
    /* Cropper Modal Styles */
    .cropper-container {
        max-height: 400px;
        overflow: hidden;
        background: #1a1a1a;
        border-radius: 8px;
    }
    
    #cropperImage {
        max-width: 100%;
        display: block;
    }
    
    .cropper-controls {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 5px;
    }
    
    .cropper-controls .btn {
        padding: 8px 12px;
    }
</style>

<?php include 'includes/footer.php'; ?>
