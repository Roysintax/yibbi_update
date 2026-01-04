<?php
require_once 'auth_check.php';
require_once '../config/database.php';

// Handle Delete Request
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    
    // Get image path to delete file
    $stmt = $pdo->prepare("SELECT image FROM blog_posts WHERE id = ?");
    $stmt->execute([$id]);
    $post = $stmt->fetch();
    
    if ($post) {
        $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
        if ($stmt->execute([$id])) {
            // Delete image file if exists
            if ($post['image'] && file_exists('../' . $post['image'])) {
                unlink('../' . $post['image']);
            }
            $_SESSION['success'] = "Blog post deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete blog post.";
        }
    }
    header("Location: manage_blog_posts.php");
    exit;
}

// Handle Form Submission (Add/Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $title = trim($_POST['title']);
    // Generate slug from title if not custom provided
    $slug = trim($_POST['slug']);
    if (empty($slug)) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    }
    $excerpt = trim($_POST['excerpt']);
    $content = $_POST['content']; 
    $author_id = (int)$_POST['author_id'];
    $type = $_POST['type'];
    $video_url = $_POST['video_url'] ?? '';
    
    $imagePath = isset($_POST['current_image']) ? $_POST['current_image'] : '';

    // Handle Image Upload (Cropped)
    if (!empty($_POST['cropped_image'])) {
        $data = $_POST['cropped_image'];
        $image_array_1 = explode(";", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $imageName = 'blog_' . time() . '.png';
        $imagePath = 'assets/images/blog/' . $imageName;
        file_put_contents('../' . $imagePath, $data);
    }

    try {
        $pdo->beginTransaction();

        if ($id > 0) {
            // Update
            $sql = "UPDATE blog_posts SET 
                    title = ?, slug = ?, excerpt = ?, content = ?, image = ?, 
                    author_id = ?, type = ?, video_url = ?, published_at = NOW() 
                    WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$title, $slug, $excerpt, $content, $imagePath, $author_id, $type, $video_url, $id]);
            
            // Update Categories (Delete all and re-insert)
            $pdo->prepare("DELETE FROM blog_post_categories WHERE post_id = ?")->execute([$id]);
            if (!empty($_POST['categories'])) {
                $stmtCat = $pdo->prepare("INSERT INTO blog_post_categories (post_id, category_id) VALUES (?, ?)");
                foreach ($_POST['categories'] as $cat_id) {
                    $stmtCat->execute([$id, $cat_id]);
                }
            }
            
            $_SESSION['success'] = "Blog post updated successfully.";
        } else {
            // Insert
            $sql = "INSERT INTO blog_posts (title, slug, excerpt, content, image, author_id, type, video_url, published_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$title, $slug, $excerpt, $content, $imagePath, $author_id, $type, $video_url]);
            $new_post_id = $pdo->lastInsertId();
            
            // Insert Categories
            if (!empty($_POST['categories'])) {
                $stmtCat = $pdo->prepare("INSERT INTO blog_post_categories (post_id, category_id) VALUES (?, ?)");
                foreach ($_POST['categories'] as $cat_id) {
                    $stmtCat->execute([$new_post_id, $cat_id]);
                }
            }

            $_SESSION['success'] = "Blog post created successfully.";
        }

        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }

    header("Location: manage_blog_posts.php");
    exit;
}

// Fetch all posts with author name and categories
$sql = "SELECT p.*, a.name as author_name, GROUP_CONCAT(pc.category_id) as category_ids 
        FROM blog_posts p 
        LEFT JOIN blog_authors a ON p.author_id = a.id 
        LEFT JOIN blog_post_categories pc ON p.id = pc.post_id
        GROUP BY p.id
        ORDER BY p.published_at DESC";
$posts = $pdo->query($sql)->fetchAll();

// Fetch Authors for dropdown
$authors = $pdo->query("SELECT * FROM blog_authors ORDER BY name")->fetchAll();

// Fetch Categories for dropdown
$categories = $pdo->query("SELECT * FROM blog_categories ORDER BY name")->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blog Posts - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="richtexteditor/rte_theme_default.css">
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
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Page Content -->
        <div id="page-content-wrapper" class="w-100">
            <?php include 'includes/header.php'; ?>

            <div class="container-fluid px-4 py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">Manage Blog Posts</h2>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#postModal" onclick="resetForm()">
                        <i class="fas fa-plus"></i> Add New Post
                    </button>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
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
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($posts as $post): ?>
                                    <tr>
                                        <td>
                                            <img src="../<?php echo !empty($post['image']) ? $post['image'] : 'assets/images/blog/01.jpg'; ?>" 
                                                 class="rounded" width="50" height="50" style="object-fit: cover;">
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($post['title']); ?></strong>
                                            <div class="small text-muted"><?php echo htmlspecialchars($post['slug']); ?></div>
                                        </td>
                                        <td><?php echo htmlspecialchars($post['author_name'] ?? 'Unknown'); ?></td>
                                        <td>
                                            <?php 
                                            // Show names of categories? 
                                            // We only have IDs here. Ideally we would join names.
                                            // For speed, just showing IDs count or simple badge.
                                            // Or let's just show count.
                                            if ($post['category_ids']) {
                                                echo '<span class="badge bg-info">' . count(explode(',', $post['category_ids'])) . ' cats</span>';
                                            } else {
                                                echo '<span class="badge bg-secondary">Uncategorized</span>';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo date('d M Y', strtotime($post['published_at'])); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-info text-white me-1" 
                                                    onclick='editPost(<?php echo json_encode($post); ?>)'>
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="?delete=<?php echo $post['id']; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Are you sure you want to delete this post?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
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

    <!-- Post Modal -->
    <div class="modal fade" id="postModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add New Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="postForm" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="post_id">
                        <input type="hidden" name="current_image" id="current_image">
                        <input type="hidden" name="cropped_image" id="cropped_image">

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" id="title" required onkeyup="generateSlug()">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control" name="slug" id="slug">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Excerpt (Small Description)</label>
                                    <textarea class="form-control" name="excerpt" id="excerpt" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Author</label>
                                    <select class="form-select" name="author_id" id="author_id" required>
                                        <option value="">Select Author</option>
                                        <?php foreach ($authors as $author): ?>
                                            <option value="<?php echo $author['id']; ?>"><?php echo htmlspecialchars($author['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Type</label>
                                    <select class="form-select" name="type" id="type" onchange="toggleTypeFields()">
                                        <option value="standard">Standard</option>
                                        <option value="video">Video</option>
                                        <option value="quote">Quote</option>
                                    </select>
                                </div>
                                <div class="mb-3 d-none" id="videoUrlField">
                                    <label class="form-label">Video URL</label>
                                    <input type="text" class="form-control" name="video_url" id="video_url" placeholder="https://youtube.com/...">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Categories</label>
                                    <div class="card p-2" style="max-height: 150px; overflow-y: auto;">
                                        <?php foreach ($categories as $cat): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="categories[]" 
                                                       value="<?php echo $cat['id']; ?>" id="cat_<?php echo $cat['id']; ?>">
                                                <label class="form-check-label" for="cat_<?php echo $cat['id']; ?>">
                                                    <?php echo htmlspecialchars($cat['name']); ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Feature Image</label>
                                    <input type="file" class="form-control" id="imageInput" accept="image/*">
                                    <div class="image-preview-container mt-2 d-none" id="cropperContainer">
                                        <img id="imageToCrop" src="" style="max-width: 100%;">
                                    </div>
                                    <div id="imagePreview" class="mt-2"></div>
                                    <button type="button" class="btn btn-primary mt-2 d-none" id="cropBtn">Crop & Save</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Content Editor - Full Width Below -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Content</label>
                                    <textarea class="form-control" name="content" id="content" rows="10" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer px-0 pb-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="richtexteditor/rte.js"></script>
    <script src="richtexteditor/plugins/all_plugins.js"></script>
    
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
                
                if (cropper) {
                    cropper.destroy();
                }
                
                cropper = new Cropper(imageToCrop, {
                    aspectRatio: 16 / 9,
                    viewMode: 1
                });
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    cropBtn.addEventListener('click', function() {
        const canvas = cropper.getCroppedCanvas({
            width: 800,
            height: 450
        });
        
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

    function generateSlug() {
        const title = document.getElementById('title').value;
        const slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
        document.getElementById('slug').value = slug;
    }

    function toggleTypeFields() {
        const type = document.getElementById('type').value;
        const videoField = document.getElementById('videoUrlField');
        if (type === 'video') {
            videoField.classList.remove('d-none');
        } else {
            videoField.classList.add('d-none');
        }
    }

    function resetForm() {
        document.getElementById('postForm').reset();
        document.getElementById('post_id').value = '';
        document.getElementById('modalTitle').innerText = 'Add New Post';
        document.getElementById('current_image').value = '';
        document.getElementById('cropped_image').value = '';
        imagePreview.innerHTML = '';
        cropperContainer.classList.add('d-none');
        cropBtn.classList.add('d-none');
        if (cropper) cropper.destroy();
        
        // Uncheck all categories
        document.querySelectorAll('input[name="categories[]"]').forEach(cb => cb.checked = false);
    }

    function editPost(post) {
        resetForm(); // Reset first
        console.log(post); // Debug
        document.getElementById('post_id').value = post.id;
        document.getElementById('title').value = post.title;
        document.getElementById('slug').value = post.slug;
        document.getElementById('excerpt').value = post.excerpt;
        document.getElementById('content').value = post.content;
        document.getElementById('author_id').value = post.author_id;
        document.getElementById('type').value = post.type;
        document.getElementById('video_url').value = post.video_url || '';
        document.getElementById('current_image').value = post.image;
        
        // Show current image
        if (post.image) {
            imagePreview.innerHTML = '<img src="../' + post.image + '" class="img-fluid rounded">';
        } else {
            imagePreview.innerHTML = '';
        }
        
        document.getElementById('modalTitle').innerText = 'Edit Post';
        toggleTypeFields();
        
        // Check categories
        if (post.category_ids) {
            const ids = post.category_ids.split(',');
            ids.forEach(id => {
                const cb = document.getElementById('cat_' + id);
                if (cb) cb.checked = true;
            });
        }
        
        var postModal = new bootstrap.Modal(document.getElementById('postModal'));
        postModal.show();
    }

    // Initialize Rich Text Editor
    var contentEditor;
    document.addEventListener('DOMContentLoaded', function() {
        contentEditor = new RichTextEditor('#content', {
            width: '100%',
            height: 300,
            toolbar: 'default'
        });
    });

    // Override editPost to set RTE content
    var originalEditPost = editPost;
    editPost = function(post) {
        originalEditPost(post);
        if (contentEditor) {
            setTimeout(function() {
                contentEditor.setHTMLCode(post.content || '');
            }, 100);
        }
    };

    // Override resetForm to clear RTE content
    var originalResetForm = resetForm;
    resetForm = function() {
        originalResetForm();
        if (contentEditor) {
            contentEditor.setHTMLCode('');
        }
    };
    </script>
</body>
</html>
