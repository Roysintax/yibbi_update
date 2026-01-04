<?php
session_start();
require_once '../config/database.php';
require_once 'auth_check.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM quotes WHERE id = $id");
    header("Location: manage_quotes.php?deleted=1");
    exit;
}

// Handle Form Submission
$success_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $quote_text = $conn->real_escape_string($_POST['quote_text']);
    $author = $conn->real_escape_string($_POST['author']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Handle Background Image
    $background_image = $_POST['current_image'] ?? '';
    if (isset($_POST['cropped_image']) && !empty($_POST['cropped_image'])) {
        $cropped_data = $_POST['cropped_image'];
        $cropped_data = str_replace(['data:image/png;base64,', 'data:image/jpeg;base64,', ' '], ['', '', '+'], $cropped_data);
        $decoded_image = base64_decode($cropped_data);
        
        $upload_dir = '../assets/images/quote/';
        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $filename = 'quote_' . time() . '.png';
        if (file_put_contents($upload_dir . $filename, $decoded_image)) {
            $background_image = 'assets/images/quote/' . $filename;
        }
    }
    
    if ($id > 0) {
        $sql = "UPDATE quotes SET quote_text='$quote_text', author='$author', background_image='$background_image', is_active=$is_active WHERE id=$id";
    } else {
        $sql = "INSERT INTO quotes (quote_text, author, background_image, is_active) VALUES ('$quote_text', '$author', '$background_image', $is_active)";
    }
    
    if ($conn->query($sql)) {
        $success_message = $id > 0 ? 'Quote updated!' : 'Quote added!';
    }
}

if (isset($_GET['deleted'])) $success_message = 'Quote deleted!';
$quotes = $conn->query("SELECT * FROM quotes ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Quotes - Admin</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <style>
        :root { --sidebar-bg: linear-gradient(180deg, #1e1e2f 0%, #1a1a2e 100%); }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
        .main-content { padding: 2rem; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .card-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0 !important; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; }
        .btn-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border: none; }
        .quote-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px; padding: 1.5rem; margin-bottom: 1rem; }
        .quote-text { font-style: italic; font-size: 1.1rem; }
        .quote-author { text-align: right; margin-top: 1rem; font-weight: bold; }
        .image-preview { max-width: 200px; border-radius: 10px; border: 3px solid #667eea; }
    </style>
</head>
<body>
    <div class="d-flex">
        <?php include 'includes/sidebar.php'; ?>
        
        <div class="main-content flex-grow-1">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-quote-left me-2"></i>Manage Quotes</h2>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#quoteModal" onclick="resetForm()">
                        <i class="fas fa-plus me-1"></i> Add Quote
                    </button>
                </div>
                
                <?php if ($success_message): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <div class="row">
                    <?php while ($quote = $quotes->fetch_assoc()): ?>
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge <?php echo $quote['is_active'] ? 'bg-success' : 'bg-secondary'; ?>">
                                        <?php echo $quote['is_active'] ? 'Active' : 'Inactive'; ?>
                                    </span>
                                    <div>
                                        <button class="btn btn-sm btn-primary" onclick='editQuote(<?php echo json_encode($quote); ?>)'>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="?delete=<?php echo $quote['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                                <blockquote class="blockquote">
                                    <p class="mb-2"><i class="fas fa-quote-left text-primary me-2"></i><?php echo htmlspecialchars($quote['quote_text']); ?></p>
                                    <footer class="blockquote-footer mt-2"><?php echo htmlspecialchars($quote['author']); ?></footer>
                                </blockquote>
                                <?php if ($quote['background_image']): ?>
                                <img src="../<?php echo htmlspecialchars($quote['background_image']); ?>" alt="BG" class="mt-2" style="max-width: 100px; border-radius: 8px;">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quote Modal -->
    <div class="modal fade" id="quoteModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <h5 class="modal-title"><i class="fas fa-quote-left me-2"></i><span id="modalTitle">Add Quote</span></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="quoteId">
                        <input type="hidden" name="current_image" id="currentImage">
                        <input type="hidden" name="cropped_image" id="croppedImage">
                        
                        <div class="mb-3">
                            <label class="form-label">Quote Text</label>
                            <textarea class="form-control" name="quote_text" id="quoteText" rows="4" required placeholder="Enter the quote..."></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Author</label>
                            <input type="text" class="form-control" name="author" id="quoteAuthor" placeholder="Prophet Muhammad (PBUH), Quran, etc.">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Background Image (Optional)</label>
                            <div class="mb-2">
                                <img id="imagePreview" src="../assets/images/quote/01.jpg" alt="Preview" class="image-preview">
                            </div>
                            <input type="file" class="form-control" id="imageInput" accept="image/*">
                        </div>
                        
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="is_active" id="isActive" checked>
                            <label class="form-check-label" for="isActive">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Crop Modal -->
    <div class="modal fade" id="cropModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Crop Image</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body text-center"><img id="cropImage" style="max-width: 100%;"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="applyCrop()">Apply</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        let cropper = null;
        
        function resetForm() {
            document.getElementById('quoteId').value = '';
            document.getElementById('quoteText').value = '';
            document.getElementById('quoteAuthor').value = '';
            document.getElementById('currentImage').value = '';
            document.getElementById('croppedImage').value = '';
            document.getElementById('imagePreview').src = '../assets/images/quote/01.jpg';
            document.getElementById('isActive').checked = true;
            document.getElementById('modalTitle').textContent = 'Add Quote';
        }
        
        function editQuote(quote) {
            document.getElementById('quoteId').value = quote.id;
            document.getElementById('quoteText').value = quote.quote_text;
            document.getElementById('quoteAuthor').value = quote.author || '';
            document.getElementById('currentImage').value = quote.background_image || '';
            document.getElementById('imagePreview').src = quote.background_image ? '../' + quote.background_image : '../assets/images/quote/01.jpg';
            document.getElementById('isActive').checked = quote.is_active == 1;
            document.getElementById('modalTitle').textContent = 'Edit Quote';
            new bootstrap.Modal(document.getElementById('quoteModal')).show();
        }
        
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    document.getElementById('cropImage').src = ev.target.result;
                    const cropModal = new bootstrap.Modal(document.getElementById('cropModal'));
                    cropModal.show();
                    document.getElementById('cropModal').addEventListener('shown.bs.modal', function() {
                        if (cropper) cropper.destroy();
                        cropper = new Cropper(document.getElementById('cropImage'), { aspectRatio: 16/9, viewMode: 1 });
                    }, {once: true});
                };
                reader.readAsDataURL(file);
            }
        });
        
        function applyCrop() {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas({ width: 1200, height: 675 });
                const base64 = canvas.toDataURL('image/png');
                document.getElementById('croppedImage').value = base64;
                document.getElementById('imagePreview').src = base64;
                bootstrap.Modal.getInstance(document.getElementById('cropModal')).hide();
            }
        }
    </script>
</body>
</html>
