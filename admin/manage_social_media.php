<?php
session_start();
require_once '../config/database.php';
require_once 'auth_check.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM social_media WHERE id = $id");
    header("Location: manage_social_media.php?deleted=1");
    exit;
}

// Handle Form Submission
$success_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $platform = $conn->real_escape_string($_POST['platform']);
    $icon_class = $conn->real_escape_string($_POST['icon_class']);
    $url = $conn->real_escape_string($_POST['url']);
    $order_index = intval($_POST['order_index']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    if ($id > 0) {
        $sql = "UPDATE social_media SET platform='$platform', icon_class='$icon_class', url='$url', 
                order_index=$order_index, is_active=$is_active WHERE id=$id";
    } else {
        $sql = "INSERT INTO social_media (platform, icon_class, url, order_index, is_active) 
                VALUES ('$platform', '$icon_class', '$url', $order_index, $is_active)";
    }
    
    if ($conn->query($sql)) {
        $success_message = $id > 0 ? 'Social media updated!' : 'Social media added!';
    }
}

if (isset($_GET['deleted'])) $success_message = 'Social media deleted!';
$socialMedia = $conn->query("SELECT * FROM social_media ORDER BY order_index ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Social Media - Admin</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <style>
        :root { --sidebar-bg: linear-gradient(180deg, #1e1e2f 0%, #1a1a2e 100%); }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
        .main-content { padding: 2rem; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .card-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0 !important; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; }
        .btn-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border: none; }
        .icon-preview { font-size: 1.5rem; width: 40px; text-align: center; }
        .icon-list { display: flex; flex-wrap: wrap; gap: 8px; max-height: 200px; overflow-y: auto; }
        .icon-item { padding: 8px 12px; border: 1px solid #ddd; border-radius: 8px; cursor: pointer; transition: all 0.2s; }
        .icon-item:hover, .icon-item.selected { background: #667eea; color: white; border-color: #667eea; }
    </style>
</head>
<body>
    <div class="d-flex">
        <?php include 'includes/sidebar.php'; ?>
        
        <div class="main-content flex-grow-1">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-share-alt me-2"></i>Manage Social Media</h2>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#socialModal" onclick="resetForm()">
                        <i class="fas fa-plus me-1"></i> Add Social Media
                    </button>
                </div>
                
                <?php if ($success_message): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-header"><h5 class="mb-0"><i class="fas fa-list me-2"></i>Social Media Links</h5></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Icon</th>
                                        <th>Platform</th>
                                        <th>URL</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($social = $socialMedia->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $social['order_index']; ?></td>
                                        <td><i class="<?php echo htmlspecialchars($social['icon_class']); ?> icon-preview"></i></td>
                                        <td><strong><?php echo htmlspecialchars($social['platform']); ?></strong></td>
                                        <td><a href="<?php echo htmlspecialchars($social['url']); ?>" target="_blank"><?php echo htmlspecialchars($social['url']); ?></a></td>
                                        <td>
                                            <?php echo $social['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick='editSocial(<?php echo json_encode($social); ?>)'>
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="?delete=<?php echo $social['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
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
                
                <!-- Icon Reference Card -->
                <div class="card mt-4">
                    <div class="card-header"><h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Common Icon Classes</h5></div>
                    <div class="card-body">
                        <div class="icon-list">
                            <span class="icon-item" onclick="selectIcon('fab fa-facebook-f')"><i class="fab fa-facebook-f"></i> fab fa-facebook-f</span>
                            <span class="icon-item" onclick="selectIcon('fab fa-twitter')"><i class="fab fa-twitter"></i> fab fa-twitter</span>
                            <span class="icon-item" onclick="selectIcon('fab fa-instagram')"><i class="fab fa-instagram"></i> fab fa-instagram</span>
                            <span class="icon-item" onclick="selectIcon('fab fa-youtube')"><i class="fab fa-youtube"></i> fab fa-youtube</span>
                            <span class="icon-item" onclick="selectIcon('fab fa-linkedin-in')"><i class="fab fa-linkedin-in"></i> fab fa-linkedin-in</span>
                            <span class="icon-item" onclick="selectIcon('fab fa-whatsapp')"><i class="fab fa-whatsapp"></i> fab fa-whatsapp</span>
                            <span class="icon-item" onclick="selectIcon('fab fa-telegram')"><i class="fab fa-telegram"></i> fab fa-telegram</span>
                            <span class="icon-item" onclick="selectIcon('fab fa-tiktok')"><i class="fab fa-tiktok"></i> fab fa-tiktok</span>
                            <span class="icon-item" onclick="selectIcon('fab fa-pinterest')"><i class="fab fa-pinterest"></i> fab fa-pinterest</span>
                            <span class="icon-item" onclick="selectIcon('fab fa-skype')"><i class="fab fa-skype"></i> fab fa-skype</span>
                            <span class="icon-item" onclick="selectIcon('fab fa-vimeo-v')"><i class="fab fa-vimeo-v"></i> fab fa-vimeo-v</span>
                            <span class="icon-item" onclick="selectIcon('fas fa-globe')"><i class="fas fa-globe"></i> fas fa-globe</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Social Modal -->
    <div class="modal fade" id="socialModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <h5 class="modal-title"><i class="fas fa-share-alt me-2"></i><span id="modalTitle">Add Social Media</span></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="socialId">
                        
                        <div class="mb-3">
                            <label class="form-label">Platform Name</label>
                            <input type="text" class="form-control" name="platform" id="platform" placeholder="Facebook, Instagram..." required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Icon Class (FontAwesome)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i id="iconPreviewModal" class="fab fa-facebook-f"></i></span>
                                <input type="text" class="form-control" name="icon_class" id="iconClass" placeholder="fab fa-facebook-f" required onchange="updateIconPreview()">
                            </div>
                            <small class="text-muted">Click icons below or enter manually</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">URL</label>
                            <input type="url" class="form-control" name="url" id="socialUrl" placeholder="https://facebook.com/yourpage" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Order</label>
                                <input type="number" class="form-control" name="order_index" id="orderIndex" value="0">
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_active" id="isActive" checked>
                                    <label class="form-check-label" for="isActive">Active</label>
                                </div>
                            </div>
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
    
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        function resetForm() {
            document.getElementById('socialId').value = '';
            document.getElementById('platform').value = '';
            document.getElementById('iconClass').value = '';
            document.getElementById('socialUrl').value = '';
            document.getElementById('orderIndex').value = '0';
            document.getElementById('isActive').checked = true;
            document.getElementById('modalTitle').textContent = 'Add Social Media';
            document.getElementById('iconPreviewModal').className = 'fab fa-facebook-f';
        }
        
        function editSocial(social) {
            document.getElementById('socialId').value = social.id;
            document.getElementById('platform').value = social.platform;
            document.getElementById('iconClass').value = social.icon_class;
            document.getElementById('socialUrl').value = social.url;
            document.getElementById('orderIndex').value = social.order_index;
            document.getElementById('isActive').checked = social.is_active == 1;
            document.getElementById('modalTitle').textContent = 'Edit Social Media';
            document.getElementById('iconPreviewModal').className = social.icon_class;
            new bootstrap.Modal(document.getElementById('socialModal')).show();
        }
        
        function selectIcon(iconClass) {
            document.getElementById('iconClass').value = iconClass;
            document.getElementById('iconPreviewModal').className = iconClass;
        }
        
        function updateIconPreview() {
            const iconClass = document.getElementById('iconClass').value;
            document.getElementById('iconPreviewModal').className = iconClass;
        }
    </script>
</body>
</html>
