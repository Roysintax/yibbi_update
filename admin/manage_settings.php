<?php
session_start();
require_once '../config/database.php';
require_once 'auth_check.php';

// Handle form submission
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_title = $conn->real_escape_string($_POST['site_title']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['address']);
    $copyright_text = $conn->real_escape_string($_POST['copyright_text']);
    $footer_about_title = $conn->real_escape_string($_POST['footer_about_title']);
    $footer_about_text = $conn->real_escape_string($_POST['footer_about_text']);
    $whatsapp_donation = $conn->real_escape_string($_POST['whatsapp_donation']);
    
    // Handle Logo Upload
    $logo = $_POST['current_logo'] ?? 'assets/images/logo/01.png';
    if (isset($_POST['cropped_logo']) && !empty($_POST['cropped_logo'])) {
        $cropped_data = $_POST['cropped_logo'];
        $cropped_data = str_replace('data:image/png;base64,', '', $cropped_data);
        $cropped_data = str_replace(' ', '+', $cropped_data);
        $decoded_image = base64_decode($cropped_data);
        
        $upload_dir = '../assets/images/logo/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $filename = 'logo_' . time() . '.png';
        $filepath = $upload_dir . $filename;
        
        if (file_put_contents($filepath, $decoded_image)) {
            $logo = 'assets/images/logo/' . $filename;
        }
    }
    
    // Handle Favicon Upload
    $favicon = $_POST['current_favicon'] ?? 'assets/images/x-icon/01.png';
    if (isset($_POST['cropped_favicon']) && !empty($_POST['cropped_favicon'])) {
        $cropped_data = $_POST['cropped_favicon'];
        $cropped_data = str_replace('data:image/png;base64,', '', $cropped_data);
        $cropped_data = str_replace(' ', '+', $cropped_data);
        $decoded_image = base64_decode($cropped_data);
        
        $upload_dir = '../assets/images/x-icon/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $filename = 'favicon_' . time() . '.png';
        $filepath = $upload_dir . $filename;
        
        if (file_put_contents($filepath, $decoded_image)) {
            $favicon = 'assets/images/x-icon/' . $filename;
        }
    }
    
    // Handle Footer About Image Upload
    $footer_about_image = $_POST['current_footer_about_image'] ?? 'assets/images/footer/footer-middle/01.jpg';
    if (isset($_POST['cropped_footer_about_image']) && !empty($_POST['cropped_footer_about_image'])) {
        $cropped_data = $_POST['cropped_footer_about_image'];
        $cropped_data = str_replace('data:image/png;base64,', '', $cropped_data);
        $cropped_data = str_replace('data:image/jpeg;base64,', '', $cropped_data);
        $cropped_data = str_replace(' ', '+', $cropped_data);
        $decoded_image = base64_decode($cropped_data);
        
        $upload_dir = '../assets/images/footer/footer-middle/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $filename = 'footer_about_' . time() . '.png';
        $filepath = $upload_dir . $filename;
        
        if (file_put_contents($filepath, $decoded_image)) {
            $footer_about_image = 'assets/images/footer/footer-middle/' . $filename;
        }
    }
    
    // Update settings
    $sql = "UPDATE settings SET 
            site_title = '$site_title',
            logo = '$logo',
            favicon = '$favicon',
            phone = '$phone',
            email = '$email',
            address = '$address',
            copyright_text = '$copyright_text',
            footer_about_title = '$footer_about_title',
            footer_about_text = '$footer_about_text',
            footer_about_image = '$footer_about_image',
            whatsapp_donation = '$whatsapp_donation'
            WHERE id = 1";
    
    if ($conn->query($sql)) {
        $success_message = 'Settings updated successfully!';
    } else {
        $error_message = 'Error updating settings: ' . $conn->error;
    }
}

// Fetch current settings
$result = $conn->query("SELECT * FROM settings WHERE id = 1");
$settings = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Settings - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <style>
        :root {
            --sidebar-bg: linear-gradient(180deg, #1e1e2f 0%, #1a1a2e 100%);
            --card-bg: #ffffff;
            --text-primary: #333;
            --text-secondary: #666;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        .main-content {
            padding: 2rem;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.25rem;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .form-control {
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            padding: 0.75rem 1rem;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        
        .image-preview-container {
            position: relative;
            display: inline-block;
            margin: 10px 0;
        }
        
        .image-preview {
            max-width: 150px;
            max-height: 150px;
            border-radius: 10px;
            border: 3px solid #667eea;
            padding: 5px;
            background: white;
        }
        
        .image-preview-sm {
            max-width: 64px;
            max-height: 64px;
        }
        
        .btn-upload {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
            color: white;
        }
        
        .btn-upload:hover {
            background: linear-gradient(135deg, #38ef7d 0%, #11998e 100%);
            color: white;
        }
        
        .section-title {
            color: #667eea;
            font-weight: 700;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        /* Modal Styles */
        .modal-content {
            border-radius: 15px;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        
        .cropper-container {
            max-height: 400px;
        }
        
        .cropper-controls {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
        }
        
        .cropper-controls .btn {
            padding: 8px 15px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-cog me-2"></i>Website Settings</h2>
                </div>
                
                <?php if ($success_message): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <?php if ($error_message): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Site Identity -->
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-globe me-2"></i>Site Identity</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Site Title</label>
                                        <input type="text" class="form-control" name="site_title" value="<?php echo htmlspecialchars($settings['site_title'] ?? ''); ?>" required>
                                    </div>
                                    
                                    <!-- Logo Upload -->
                                    <div class="mb-3">
                                        <label class="form-label">Logo</label>
                                        <div class="image-preview-container">
                                            <img src="../<?php echo htmlspecialchars($settings['logo'] ?? 'assets/images/logo/01.png'); ?>" alt="Logo" class="image-preview" id="logoPreview">
                                        </div>
                                        <input type="hidden" name="current_logo" value="<?php echo htmlspecialchars($settings['logo'] ?? ''); ?>">
                                        <input type="hidden" name="cropped_logo" id="croppedLogo">
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-upload btn-sm" data-bs-toggle="modal" data-bs-target="#logoModal">
                                                <i class="fas fa-upload me-1"></i> Change Logo
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Favicon Upload -->
                                    <div class="mb-3">
                                        <label class="form-label">Favicon</label>
                                        <div class="image-preview-container">
                                            <img src="../<?php echo htmlspecialchars($settings['favicon'] ?? 'assets/images/x-icon/01.png'); ?>" alt="Favicon" class="image-preview image-preview-sm" id="faviconPreview">
                                        </div>
                                        <input type="hidden" name="current_favicon" value="<?php echo htmlspecialchars($settings['favicon'] ?? ''); ?>">
                                        <input type="hidden" name="cropped_favicon" id="croppedFavicon">
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-upload btn-sm" data-bs-toggle="modal" data-bs-target="#faviconModal">
                                                <i class="fas fa-upload me-1"></i> Change Favicon
                                            </button>
                                        </div>
                                        <small class="text-muted">Recommended: 32x32px or 64x64px</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contact Information -->
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-address-card me-2"></i>Contact Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($settings['phone'] ?? ''); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($settings['email'] ?? ''); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" name="address" rows="3"><?php echo htmlspecialchars($settings['address'] ?? ''); ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">WhatsApp Donation Number</label>
                                        <input type="text" class="form-control" name="whatsapp_donation" value="<?php echo htmlspecialchars($settings['whatsapp_donation'] ?? ''); ?>" placeholder="628xxxxxxxxxx">
                                        <small class="text-muted">Format: Country code + number (e.g., 6281234567890)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Footer Settings -->
                        <div class="col-lg-12 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-shoe-prints me-2"></i>Footer Settings</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Copyright Text</label>
                                                <input type="text" class="form-control" name="copyright_text" value="<?php echo htmlspecialchars($settings['copyright_text'] ?? ''); ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Footer About Title</label>
                                                <input type="text" class="form-control" name="footer_about_title" value="<?php echo htmlspecialchars($settings['footer_about_title'] ?? ''); ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Footer About Text</label>
                                                <textarea class="form-control" name="footer_about_text" rows="4"><?php echo htmlspecialchars($settings['footer_about_text'] ?? ''); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Footer About Image</label>
                                                <div class="image-preview-container">
                                                    <img src="../<?php echo htmlspecialchars($settings['footer_about_image'] ?? 'assets/images/footer/footer-middle/01.jpg'); ?>" alt="Footer Image" class="image-preview" id="footerAboutImagePreview">
                                                </div>
                                                <input type="hidden" name="current_footer_about_image" value="<?php echo htmlspecialchars($settings['footer_about_image'] ?? ''); ?>">
                                                <input type="hidden" name="cropped_footer_about_image" id="croppedFooterAboutImage">
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-upload btn-sm" data-bs-toggle="modal" data-bs-target="#footerImageModal">
                                                        <i class="fas fa-upload me-1"></i> Change Image
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mb-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Logo Upload Modal -->
    <div class="modal fade" id="logoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-crop me-2"></i>Upload & Crop Logo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="file" id="logoInput" accept="image/*" class="form-control mb-3">
                    <div class="text-center">
                        <img id="logoCropImage" style="max-width: 100%; display: none;">
                    </div>
                    <div class="cropper-controls" style="display: none;" id="logoControls">
                        <button type="button" class="btn btn-outline-secondary" onclick="logoRotate(-90)"><i class="fas fa-undo"></i></button>
                        <button type="button" class="btn btn-outline-secondary" onclick="logoRotate(90)"><i class="fas fa-redo"></i></button>
                        <button type="button" class="btn btn-outline-secondary" onclick="logoZoom(0.1)"><i class="fas fa-search-plus"></i></button>
                        <button type="button" class="btn btn-outline-secondary" onclick="logoZoom(-0.1)"><i class="fas fa-search-minus"></i></button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="applyLogoCrop()">Apply</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Favicon Upload Modal -->
    <div class="modal fade" id="faviconModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-crop me-2"></i>Upload & Crop Favicon</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="file" id="faviconInput" accept="image/*" class="form-control mb-3">
                    <div class="text-center">
                        <img id="faviconCropImage" style="max-width: 100%; display: none;">
                    </div>
                    <div class="cropper-controls" style="display: none;" id="faviconControls">
                        <button type="button" class="btn btn-outline-secondary" onclick="faviconRotate(-90)"><i class="fas fa-undo"></i></button>
                        <button type="button" class="btn btn-outline-secondary" onclick="faviconRotate(90)"><i class="fas fa-redo"></i></button>
                        <button type="button" class="btn btn-outline-secondary" onclick="faviconZoom(0.1)"><i class="fas fa-search-plus"></i></button>
                        <button type="button" class="btn btn-outline-secondary" onclick="faviconZoom(-0.1)"><i class="fas fa-search-minus"></i></button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="applyFaviconCrop()">Apply</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer Image Upload Modal -->
    <div class="modal fade" id="footerImageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-crop me-2"></i>Upload & Crop Footer Image</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="file" id="footerImageInput" accept="image/*" class="form-control mb-3">
                    <div class="text-center">
                        <img id="footerImageCropImage" style="max-width: 100%; display: none;">
                    </div>
                    <div class="cropper-controls" style="display: none;" id="footerImageControls">
                        <button type="button" class="btn btn-outline-secondary" onclick="footerImageRotate(-90)"><i class="fas fa-undo"></i></button>
                        <button type="button" class="btn btn-outline-secondary" onclick="footerImageRotate(90)"><i class="fas fa-redo"></i></button>
                        <button type="button" class="btn btn-outline-secondary" onclick="footerImageZoom(0.1)"><i class="fas fa-search-plus"></i></button>
                        <button type="button" class="btn btn-outline-secondary" onclick="footerImageZoom(-0.1)"><i class="fas fa-search-minus"></i></button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="applyFooterImageCrop()">Apply</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        // Logo Cropper
        let logoCropper = null;
        const logoInput = document.getElementById('logoInput');
        const logoCropImage = document.getElementById('logoCropImage');
        
        logoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    logoCropImage.src = event.target.result;
                    logoCropImage.style.display = 'block';
                    document.getElementById('logoControls').style.display = 'flex';
                    
                    if (logoCropper) {
                        logoCropper.destroy();
                    }
                    
                    logoCropper = new Cropper(logoCropImage, {
                        aspectRatio: NaN,
                        viewMode: 1,
                        autoCropArea: 0.8
                    });
                };
                reader.readAsDataURL(file);
            }
        });
        
        function logoRotate(degree) {
            if (logoCropper) logoCropper.rotate(degree);
        }
        
        function logoZoom(ratio) {
            if (logoCropper) logoCropper.zoom(ratio);
        }
        
        function applyLogoCrop() {
            if (logoCropper) {
                const canvas = logoCropper.getCroppedCanvas({
                    width: 200,
                    height: 80
                });
                const base64 = canvas.toDataURL('image/png');
                document.getElementById('croppedLogo').value = base64;
                document.getElementById('logoPreview').src = base64;
                bootstrap.Modal.getInstance(document.getElementById('logoModal')).hide();
            }
        }
        
        // Favicon Cropper
        let faviconCropper = null;
        const faviconInput = document.getElementById('faviconInput');
        const faviconCropImage = document.getElementById('faviconCropImage');
        
        faviconInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    faviconCropImage.src = event.target.result;
                    faviconCropImage.style.display = 'block';
                    document.getElementById('faviconControls').style.display = 'flex';
                    
                    if (faviconCropper) {
                        faviconCropper.destroy();
                    }
                    
                    faviconCropper = new Cropper(faviconCropImage, {
                        aspectRatio: 1,
                        viewMode: 1,
                        autoCropArea: 0.8
                    });
                };
                reader.readAsDataURL(file);
            }
        });
        
        function faviconRotate(degree) {
            if (faviconCropper) faviconCropper.rotate(degree);
        }
        
        function faviconZoom(ratio) {
            if (faviconCropper) faviconCropper.zoom(ratio);
        }
        
        function applyFaviconCrop() {
            if (faviconCropper) {
                const canvas = faviconCropper.getCroppedCanvas({
                    width: 64,
                    height: 64
                });
                const base64 = canvas.toDataURL('image/png');
                document.getElementById('croppedFavicon').value = base64;
                document.getElementById('faviconPreview').src = base64;
                bootstrap.Modal.getInstance(document.getElementById('faviconModal')).hide();
            }
        }
        
        // Footer Image Cropper
        let footerImageCropper = null;
        const footerImageInput = document.getElementById('footerImageInput');
        const footerImageCropImage = document.getElementById('footerImageCropImage');
        
        footerImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    footerImageCropImage.src = event.target.result;
                    footerImageCropImage.style.display = 'block';
                    document.getElementById('footerImageControls').style.display = 'flex';
                    
                    if (footerImageCropper) {
                        footerImageCropper.destroy();
                    }
                    
                    footerImageCropper = new Cropper(footerImageCropImage, {
                        aspectRatio: 16/9,
                        viewMode: 1,
                        autoCropArea: 0.8
                    });
                };
                reader.readAsDataURL(file);
            }
        });
        
        function footerImageRotate(degree) {
            if (footerImageCropper) footerImageCropper.rotate(degree);
        }
        
        function footerImageZoom(ratio) {
            if (footerImageCropper) footerImageZoom.zoom(ratio);
        }
        
        function applyFooterImageCrop() {
            if (footerImageCropper) {
                const canvas = footerImageCropper.getCroppedCanvas({
                    width: 400,
                    height: 225
                });
                const base64 = canvas.toDataURL('image/png');
                document.getElementById('croppedFooterAboutImage').value = base64;
                document.getElementById('footerAboutImagePreview').src = base64;
                bootstrap.Modal.getInstance(document.getElementById('footerImageModal')).hide();
            }
        }
    </script>
</body>
</html>
