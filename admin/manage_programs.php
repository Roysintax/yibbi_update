<?php
session_start();
require_once '../config/database.php';
require_once 'auth_check.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM programs WHERE id = $id");
    header("Location: manage_programs.php?deleted=1");
    exit;
}

// Handle Form Submission (Add/Edit)
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $category = $conn->real_escape_string($_POST['category']);
    $type = $conn->real_escape_string($_POST['type']);
    $amount_raised = floatval($_POST['amount_raised']);
    $target_amount = floatval($_POST['target_amount']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Handle Image Upload
    $image = $_POST['current_image'] ?? '';
    if (isset($_POST['cropped_image']) && !empty($_POST['cropped_image'])) {
        $cropped_data = $_POST['cropped_image'];
        $cropped_data = str_replace('data:image/png;base64,', '', $cropped_data);
        $cropped_data = str_replace('data:image/jpeg;base64,', '', $cropped_data);
        $cropped_data = str_replace(' ', '+', $cropped_data);
        $decoded_image = base64_decode($cropped_data);
        
        $upload_dir = '../assets/images/campaign/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $filename = 'program_' . time() . '.png';
        $filepath = $upload_dir . $filename;
        
        if (file_put_contents($filepath, $decoded_image)) {
            $image = 'assets/images/campaign/' . $filename;
        }
    }
    
    if ($id > 0) {
        // Update
        $sql = "UPDATE programs SET 
                title = '$title',
                description = '$description',
                image = '$image',
                category = '$category',
                type = '$type',
                amount_raised = $amount_raised,
                target_amount = $target_amount,
                is_active = $is_active
                WHERE id = $id";
    } else {
        // Insert
        $sql = "INSERT INTO programs (title, description, image, category, type, amount_raised, target_amount, is_active) 
                VALUES ('$title', '$description', '$image', '$category', '$type', $amount_raised, $target_amount, $is_active)";
    }
    
    if ($conn->query($sql)) {
        $success_message = $id > 0 ? 'Program updated successfully!' : 'Program added successfully!';
    } else {
        $error_message = 'Error: ' . $conn->error;
    }
}

// Fetch all programs
$programs = $conn->query("SELECT * FROM programs ORDER BY id DESC");

// Fetch single program for editing
$editProgram = null;
if (isset($_GET['edit'])) {
    $editId = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM programs WHERE id = $editId");
    $editProgram = $result->fetch_assoc();
}

if (isset($_GET['deleted'])) {
    $success_message = 'Program deleted successfully!';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Programs - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <style>
        :root {
            --sidebar-bg: linear-gradient(180deg, #1e1e2f 0%, #1a1a2e 100%);
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .main-content { padding: 2rem; }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
        }
        .table img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        .badge-regular { background: #667eea; }
        .badge-urgent { background: #dc3545; }
        .progress { height: 10px; border-radius: 5px; }
        .image-preview {
            max-width: 200px;
            border-radius: 10px;
            border: 3px solid #667eea;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <?php include 'includes/sidebar.php'; ?>
        
        <div class="main-content flex-grow-1">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-hand-holding-heart me-2"></i>Manage Programs</h2>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#programModal" onclick="resetForm()">
                        <i class="fas fa-plus me-1"></i> Add Program
                    </button>
                </div>
                
                <?php if ($success_message): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <!-- Programs Table -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Programs</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Progress</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($program = $programs->fetch_assoc()): 
                                        $percentage = $program['target_amount'] > 0 ? round(($program['amount_raised'] / $program['target_amount']) * 100) : 0;
                                    ?>
                                    <tr>
                                        <td><img src="../<?php echo htmlspecialchars($program['image']); ?>" alt=""></td>
                                        <td><strong><?php echo htmlspecialchars($program['title']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($program['category']); ?></td>
                                        <td style="min-width: 150px;">
                                            <div class="d-flex justify-content-between small mb-1">
                                                <span>$<?php echo number_format($program['amount_raised']); ?></span>
                                                <span>$<?php echo number_format($program['target_amount']); ?></span>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" style="width: <?php echo $percentage; ?>%"></div>
                                            </div>
                                            <small class="text-muted"><?php echo $percentage; ?>%</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?php echo $program['type']; ?>">
                                                <?php echo ucfirst($program['type']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($program['is_active']): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="editProgram(<?php echo htmlspecialchars(json_encode($program)); ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="?delete=<?php echo $program['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this program?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Program Modal -->
    <div class="modal fade" id="programModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" id="programForm">
                    <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <h5 class="modal-title"><i class="fas fa-hand-holding-heart me-2"></i><span id="modalTitle">Add Program</span></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="programId">
                        <input type="hidden" name="current_image" id="currentImage">
                        <input type="hidden" name="cropped_image" id="croppedImage">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="programTitle" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <input type="text" class="form-control" name="category" id="programCategory" placeholder="Food, Education, Medical...">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="programDescription" rows="3" required></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Amount Raised ($)</label>
                                <input type="number" class="form-control" name="amount_raised" id="amountRaised" step="0.01" value="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Target Amount ($)</label>
                                <input type="number" class="form-control" name="target_amount" id="targetAmount" step="0.01" value="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Type</label>
                                <select class="form-select" name="type" id="programType">
                                    <option value="regular">Regular</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <div class="mb-2">
                                <img id="imagePreview" src="../assets/images/campaign/01.jpg" alt="Preview" class="image-preview">
                            </div>
                            <input type="file" class="form-control" id="imageInput" accept="image/*">
                        </div>
                        
                        <div class="form-check mb-3">
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
    
    <!-- Image Crop Modal -->
    <div class="modal fade" id="cropModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="cropImage" style="max-width: 100%;">
                </div>
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
            document.getElementById('programForm').reset();
            document.getElementById('programId').value = '';
            document.getElementById('currentImage').value = '';
            document.getElementById('croppedImage').value = '';
            document.getElementById('imagePreview').src = '../assets/images/campaign/01.jpg';
            document.getElementById('modalTitle').textContent = 'Add Program';
            document.getElementById('isActive').checked = true;
        }
        
        function editProgram(program) {
            document.getElementById('programId').value = program.id;
            document.getElementById('programTitle').value = program.title;
            document.getElementById('programDescription').value = program.description;
            document.getElementById('programCategory').value = program.category || '';
            document.getElementById('programType').value = program.type;
            document.getElementById('amountRaised').value = program.amount_raised;
            document.getElementById('targetAmount').value = program.target_amount;
            document.getElementById('currentImage').value = program.image;
            document.getElementById('imagePreview').src = '../' + program.image;
            document.getElementById('isActive').checked = program.is_active == 1;
            document.getElementById('modalTitle').textContent = 'Edit Program';
            
            new bootstrap.Modal(document.getElementById('programModal')).show();
        }
        
        // Image cropper
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('cropImage').src = event.target.result;
                    
                    const cropModal = new bootstrap.Modal(document.getElementById('cropModal'));
                    cropModal.show();
                    
                    document.getElementById('cropModal').addEventListener('shown.bs.modal', function() {
                        if (cropper) cropper.destroy();
                        cropper = new Cropper(document.getElementById('cropImage'), {
                            aspectRatio: 4/3,
                            viewMode: 1
                        });
                    }, {once: true});
                };
                reader.readAsDataURL(file);
            }
        });
        
        function applyCrop() {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas({ width: 600, height: 450 });
                const base64 = canvas.toDataURL('image/png');
                document.getElementById('croppedImage').value = base64;
                document.getElementById('imagePreview').src = base64;
                bootstrap.Modal.getInstance(document.getElementById('cropModal')).hide();
            }
        }
    </script>
</body>
</html>
