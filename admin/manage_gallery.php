<?php
require_once 'auth_check.php';
require_once '../config/database.php';

// Handle Delete Request
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT image FROM gallery_items WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    
    if ($item) {
        $stmt = $pdo->prepare("DELETE FROM gallery_items WHERE id = ?");
        if ($stmt->execute([$id])) {
            if ($item['image'] && file_exists('../' . $item['image'])) {
                unlink('../' . $item['image']);
            }
            $_SESSION['success'] = "Gallery item deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete gallery item.";
        }
    }
    header("Location: manage_gallery.php");
    exit;
}

// Handle Form Submission (Add/Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $title = trim($_POST['title']);
    $subtitle = trim($_POST['subtitle']);
    
    // Process Categories (Array of slugs to space-separated string)
    $categories_input = isset($_POST['categories']) ? $_POST['categories'] : [];
    
    // Process Categories (Array of slugs to space-separated string)
    $categories_input = isset($_POST['categories']) ? $_POST['categories'] : [];
    
    // Save selected categories as space separated string
    $categories_str = implode(' ', $categories_input);

    $imagePath = isset($_POST['current_image']) ? $_POST['current_image'] : '';

    if (!empty($_POST['cropped_image'])) {
        $data = $_POST['cropped_image'];
        $image_array_1 = explode(";", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $imageName = 'gallery_' . time() . '.png';
        $imagePath = 'assets/images/gallery/' . $imageName; // Store in gallery folder
        if (!file_exists('../assets/images/gallery')) {
            mkdir('../assets/images/gallery', 0777, true);
        }
        file_put_contents('../' . $imagePath, $data);
    }

    try {
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE gallery_items SET title = ?, subtitle = ?, image = ?, categories = ? WHERE id = ?");
            $stmt->execute([$title, $subtitle, $imagePath, $categories_str, $id]);
            $_SESSION['success'] = "Gallery item updated successfully.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO gallery_items (title, subtitle, image, categories) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $subtitle, $imagePath, $categories_str]);
            $_SESSION['success'] = "Gallery item added successfully.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
    
    header("Location: manage_gallery.php");
    exit;
}

$items = $pdo->query("SELECT * FROM gallery_items ORDER BY created_at DESC")->fetchAll();
$categories = $pdo->query("SELECT * FROM gallery_categories WHERE slug != '*' ORDER BY display_order")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .image-preview-container {
            max-width: 100%;
            height: 300px;
            overflow: hidden;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <?php include 'includes/sidebar.php'; ?>
        <div id="page-content-wrapper" class="w-100">
            <?php include 'includes/header.php'; ?>
            
            <div class="container-fluid px-4 py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">Manage Gallery</h2>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#galleryModal" onclick="resetForm()">
                        <i class="fas fa-plus"></i> Add New Item
                    </button>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show"><?php echo $_SESSION['success']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show"><?php echo $_SESSION['error']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Subtitle</th>
                                        <th>Categories</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td><img src="../<?php echo $item['image']; ?>" width="60" class="rounded"></td>
                                        <td><?php echo htmlspecialchars($item['title']); ?></td>
                                        <td><?php echo htmlspecialchars($item['subtitle']); ?></td>
                                        <td>
                                            <?php 
                                            // Make category slugs readable? Or just show tags
                                            $cats = explode(' ', $item['categories']);
                                            foreach($cats as $cat) {
                                                // Remove dot if exists for display
                                                $cleanCat = str_replace('.', '', $cat);
                                                echo '<span class="badge bg-secondary me-1">'.htmlspecialchars($cleanCat).'</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info text-white" onclick='editItem(<?php echo json_encode($item); ?>)'><i class="fas fa-edit"></i></button>
                                            <a href="?delete=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="galleryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Gallery Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="galleryForm" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="item_id">
                        <input type="hidden" name="current_image" id="current_image">
                        <input type="hidden" name="cropped_image" id="cropped_image">
                        
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subtitle</label>
                            <input type="text" class="form-control" name="subtitle" id="subtitle">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Categories</label>
                            <div class="card p-2" style="max-height: 150px; overflow-y: auto;">
                                <?php foreach ($categories as $cat): ?>
                                    <div class="form-check">
                                        <!-- Store clean slug (remove dot if exists in DB) -->
                                        <?php $cleanSlug = str_replace('.', '', $cat['slug']); ?>
                                        <input class="form-check-input" type="checkbox" name="categories[]" 
                                               value="<?php echo $cleanSlug; ?>" id="cat_<?php echo $cleanSlug; ?>">
                                        <label class="form-check-label" for="cat_<?php echo $cleanSlug; ?>">
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" id="imageInput" accept="image/*">
                            <div class="image-preview-container mt-2 d-none" id="cropperContainer">
                                <img id="imageToCrop" src="" style="max-width: 100%;">
                            </div>
                            <div id="imagePreview" class="mt-2"></div>
                            <button type="button" class="btn btn-primary mt-2 d-none" id="cropBtn">Crop & Save</button>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Save Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
    let cropper;
    const imageInput = document.getElementById('imageInput');
    const imageToCrop = document.getElementById('imageToCrop');
    const cropperContainer = document.getElementById('cropperContainer');
    const cropBtn = document.getElementById('cropBtn');
    const croppedImageInput = document.getElementById('cropped_image');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imageToCrop.src = e.target.result;
                cropperContainer.classList.remove('d-none');
                cropBtn.classList.remove('d-none');
                if (cropper) cropper.destroy();
                cropper = new Cropper(imageToCrop, { aspectRatio: 4/3, viewMode: 1 });
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    cropBtn.addEventListener('click', function() {
        const canvas = cropper.getCroppedCanvas({ width: 800, height: 600 });
        canvas.toBlob(function(blob) {
            const reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                const base64data = reader.result;
                croppedImageInput.value = base64data;
                imagePreview.innerHTML = '<img src="' + base64data + '" class="img-fluid rounded">';
                cropperContainer.classList.add('d-none');
                cropBtn.classList.add('d-none');
            }
        });
    });

    function resetForm() {
        document.getElementById('galleryForm').reset();
        document.getElementById('item_id').value = '';
        document.getElementById('modalTitle').innerText = 'Add Gallery Item';
        imagePreview.innerHTML = '';
        cropperContainer.classList.add('d-none');
        cropBtn.classList.add('d-none');
        document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
    }

    function editItem(item) {
        resetForm();
        document.getElementById('item_id').value = item.id;
        document.getElementById('title').value = item.title;
        document.getElementById('subtitle').value = item.subtitle;
        document.getElementById('current_image').value = item.image;
        document.getElementById('modalTitle').innerText = 'Edit Gallery Item';
        if (item.image) imagePreview.innerHTML = '<img src="../' + item.image + '" class="img-fluid rounded">';
        
        if (item.categories) {
            const cats = item.categories.split(' ');
            cats.forEach(slug => {
                const cleanSlug = slug.replace('.', '');
                const cb = document.getElementById('cat_' + cleanSlug);
                if (cb) cb.checked = true;
            });
        }
        new bootstrap.Modal(document.getElementById('galleryModal')).show();
    }
    </script>
</body>
</html>
