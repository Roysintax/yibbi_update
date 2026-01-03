<?php
require_once 'config/database.php';
include 'includes/header.php';

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $button_text = $_POST['button_text'];
    $button_link = $_POST['button_link'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Handle Image Upload
    $imagePath = '';
    
    // Check if cropped image data is present
    if (!empty($_POST['cropped_image'])) {
        $data = $_POST['cropped_image'];
        
        // Remove the data:image/png;base64, part
        $image_array_1 = explode(";", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        
        // Ensure directory exists
        $target_dir = "../assets/images/banner/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // Generate new filename
        $imageName = 'banner_' . time() . '.png';
        $target_file = $target_dir . $imageName;
        
        // Save file
        file_put_contents($target_file, $data);
        $imagePath = "assets/images/banner/" . $imageName;
    }
    
    // Insert into database
    if (!empty($imagePath)) {
        $stmt = $conn->prepare("INSERT INTO banners (image, title, subtitle, button_text, button_link, is_active) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $imagePath, $title, $subtitle, $button_text, $button_link, $is_active);
        
        if ($stmt->execute()) {
            echo "<script>window.location.href='manage_banners.php?status=success';</script>";
            exit;
        } else {
            $error = "Error: " . $stmt->error;
        }
    } else {
        $error = "Please upload an image.";
    }
}
?>

<?php include 'includes/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header-wrapper">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div>
                <h1>
                    <i class="fas fa-plus me-3"></i>Add New Banner
                </h1>
                <p class="text-muted mb-0 mt-2">Tambahkan gambar slider baru untuk halaman utama</p>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="manage_banners.php" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-4">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form method="POST" action="" enctype="multipart/form-data">
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Banner Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                            <div class="form-text">Judul utama yang akan ditampilkan di slider.</div>
                        </div>

                        <div class="mb-3">
                            <label for="subtitle" class="form-label">Subtitle (Description)</label>
                            <textarea class="form-control" id="subtitle" name="subtitle" rows="3"></textarea>
                            <div class="form-text">Deskripsi singkat di bawah judul.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="button_text" class="form-label">Button Text</label>
                                <input type="text" class="form-control" id="button_text" name="button_text">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="button_link" class="form-label">Button Link</label>
                                <input type="text" class="form-control" id="button_link" name="button_link" value="#">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                <label class="form-check-label" for="is_active">Active Status</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Banner Image</label>
                        <div class="image-upload-wrapper text-center">
                            <!-- Image Preview -->
                            <div class="current-image-preview mb-3">
                                <img src="../assets/images/no-image.png" id="previewImg" alt="Preview" class="img-fluid rounded" style="max-height: 200px; display: none;">
                                <div id="placeholderImg" class="py-5 text-muted bg-light rounded border">
                                    <i class="fas fa-image fa-3x mb-2 text-secondary"></i>
                                    <p class="mb-0">No image selected</p>
                                </div>
                            </div>
                            
                            <!-- Upload Button -->
                            <div class="upload-section">
                                <div class="upload-label btn btn-outline-primary w-100" id="uploadTrigger">
                                    <i class="fas fa-cloud-upload-alt me-2"></i>Choose Image
                                </div>
                                <input type="file" id="imageUpload" accept="image/*" style="display: none;">
                                <small class="text-muted d-block mt-2">Recommended size: 1920x850px</small>
                            </div>
                            
                            <!-- Hidden input for cropped data -->
                            <input type="hidden" name="cropped_image" id="croppedImageData">
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i>Save Banner
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Image Cropper Modal -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropperModalLabel">Crop Banner Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 bg-dark">
                <div class="cropper-container" style="height: 500px;">
                    <img id="cropperImage" src="" alt="To Crop" style="max-width: 100%; display: block;">
                </div>
                <div class="cropper-controls bg-dark p-3 text-center border-top border-secondary">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-secondary btn-sm" id="rotateLeft" title="Rotate Left"><i class="fas fa-undo"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" id="rotateRight" title="Rotate Right"><i class="fas fa-redo"></i></button>
                    </div>
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-secondary btn-sm" id="zoomIn" title="Zoom In"><i class="fas fa-search-plus"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" id="zoomOut" title="Zoom Out"><i class="fas fa-search-minus"></i></button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary btn-sm" id="resetCrop" title="Reset"><i class="fas fa-sync"></i> Reset</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="applyCrop">Apply Crop</button>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let cropper = null;
    const uploadTrigger = document.getElementById('uploadTrigger');
    const imageUpload = document.getElementById('imageUpload');
    const cropperImage = document.getElementById('cropperImage');
    const croppedImageData = document.getElementById('croppedImageData');
    const previewImg = document.getElementById('previewImg');
    const placeholderImg = document.getElementById('placeholderImg');
    let cropperModal = null;

    if (uploadTrigger && imageUpload) {
        uploadTrigger.addEventListener('click', function() {
            imageUpload.click();
        });

        imageUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (!file.type.match('image.*')) {
                    alert('Please upload an image file only.');
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(event) {
                    cropperImage.src = event.target.result;
                    if (!cropperModal && typeof bootstrap !== 'undefined') {
                        cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));
                    }
                    if (cropperModal) cropperModal.show();
                    
                    document.getElementById('cropperModal').addEventListener('shown.bs.modal', function() {
                        if (cropper) cropper.destroy();
                        cropper = new Cropper(cropperImage, {
                            aspectRatio: 667 / 630, // Fixed Banner Ratio
                            viewMode: 1,
                            autoCropArea: 0.9,
                            responsive: true
                        });
                    }, { once: true });
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Cropper Controls
    document.getElementById('rotateLeft').addEventListener('click', () => { if(cropper) cropper.rotate(-45); });
    document.getElementById('rotateRight').addEventListener('click', () => { if(cropper) cropper.rotate(45); });
    document.getElementById('zoomIn').addEventListener('click', () => { if(cropper) cropper.zoom(0.1); });
    document.getElementById('zoomOut').addEventListener('click', () => { if(cropper) cropper.zoom(-0.1); });
    document.getElementById('resetCrop').addEventListener('click', () => { if(cropper) cropper.reset(); });

    document.getElementById('applyCrop').addEventListener('click', function() {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 667,
                height: 630,
                fillColor: '#fff'
            });
            const base64 = canvas.toDataURL('image/png');
            croppedImageData.value = base64;
            
            // Show preview
            previewImg.src = base64;
            previewImg.style.display = 'block';
            placeholderImg.style.display = 'none';
            
            if (cropperModal) cropperModal.hide();
        }
    });
});
</script>
