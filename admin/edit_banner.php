<?php
require_once 'config/database.php';
include 'includes/header.php';

if (!isset($_GET['id'])) {
    header("Location: manage_banners.php");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM banners WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Banner not found.";
    exit;
}

$banner = $result->fetch_assoc();

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $button_text = $_POST['button_text'];
    $button_link = $_POST['button_link'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    $imagePath = $banner['image']; // Default to existing image
    
    // Check if new cropped image data is present
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
        
        // Optional: Delete old image if it's not the default one and exists
        if ($banner['image'] && file_exists("../" . $banner['image']) && $banner['image'] != 'assets/images/banner/01.png') {
            unlink("../" . $banner['image']);
        }
    }
    
    // Update database
    $stmt = $conn->prepare("UPDATE banners SET image = ?, title = ?, subtitle = ?, button_text = ?, button_link = ?, is_active = ? WHERE id = ?");
    $stmt->bind_param("sssssii", $imagePath, $title, $subtitle, $button_text, $button_link, $is_active, $id);
    
    if ($stmt->execute()) {
        echo "<script>window.location.href='manage_banners.php?status=updated';</script>";
        exit;
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<?php include 'includes/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header-wrapper">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div>
                <h1>
                    <i class="fas fa-edit me-3"></i>Edit Banner
                </h1>
                <p class="text-muted mb-0 mt-2">Edit informasi dan gambar banner</p>
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
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($banner['title']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="subtitle" class="form-label">Subtitle (Description)</label>
                            <textarea class="form-control" id="subtitle" name="subtitle" rows="3"><?php echo htmlspecialchars($banner['subtitle']); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="button_text" class="form-label">Button Text</label>
                                <input type="text" class="form-control" id="button_text" name="button_text" value="<?php echo htmlspecialchars($banner['button_text']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="button_link" class="form-label">Button Link</label>
                                <input type="text" class="form-control" id="button_link" name="button_link" value="<?php echo htmlspecialchars($banner['button_link']); ?>">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" <?php echo $banner['is_active'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="is_active">Active Status</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Banner Image</label>
                        <div class="image-upload-wrapper text-center">
                            <!-- Image Preview -->
                            <div class="current-image-preview mb-3">
                                <img src="../<?php echo htmlspecialchars($banner['image']); ?>" id="previewImg" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                            
                            <!-- Upload Button -->
                            <div class="upload-section">
                                <div class="upload-label btn btn-outline-primary w-100" id="uploadTrigger">
                                    <i class="fas fa-cloud-upload-alt me-2"></i>Change Image
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
                            <i class="fas fa-save me-2"></i>Update Banner
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Image Cropper Modal (Same as Add Page) -->
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
                        <button type="button" class="btn btn-secondary btn-sm" id="rotateLeft"><i class="fas fa-undo"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" id="rotateRight"><i class="fas fa-redo"></i></button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary btn-sm" id="resetCrop"><i class="fas fa-sync"></i> Reset</button>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm ms-3" id="applyCrop">Apply Crop</button>
                </div>
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
                            aspectRatio: 667 / 630,
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

    // Basic Cropper Controls
    const rotateLeft = document.getElementById('rotateLeft');
    if(rotateLeft) rotateLeft.addEventListener('click', () => { if(cropper) cropper.rotate(-45); });
    
    const rotateRight = document.getElementById('rotateRight');
    if(rotateRight) rotateRight.addEventListener('click', () => { if(cropper) cropper.rotate(45); });
    
    const resetCrop = document.getElementById('resetCrop');
    if(resetCrop) resetCrop.addEventListener('click', () => { if(cropper) cropper.reset(); });

    const applyCrop = document.getElementById('applyCrop');
    if(applyCrop) applyCrop.addEventListener('click', function() {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 667,
                height: 630
            });
            const base64 = canvas.toDataURL('image/png');
            croppedImageData.value = base64;
            
            previewImg.src = base64;
            if (cropperModal) cropperModal.hide();
        }
    });
});
</script>
