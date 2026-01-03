<?php
require_once 'config/database.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$message = "";
$error = "";

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = 1; // Assuming we are editing the first/only record
    $title = $conn->real_escape_string($_POST['title']);
    $heading = $conn->real_escape_string($_POST['heading']);
    $subheading = $conn->real_escape_string($_POST['subheading']);
    $description = $conn->real_escape_string($_POST['description']);
    $button_text = $conn->real_escape_string($_POST['button_text']);
    $button_link = $conn->real_escape_string($_POST['button_link']);
    // For simplicity, we are just taking image path as text for now, or existing
    $image = $conn->real_escape_string($_POST['image']);

    $sql = "UPDATE about_section SET 
            title='$title', 
            heading='$heading', 
            subheading='$subheading', 
            description='$description', 
            button_text='$button_text', 
            button_link='$button_link',
            image='$image'
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        $message = "Record updated successfully";
    } else {
        $error = "Error updating record: " . $conn->error;
    }
}

// Fetch Data
$sql = "SELECT * FROM about_section WHERE id=1";
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
            <form method="POST" action="">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Section Title (Small Top)</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($data['title']) ? $data['title'] : ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="subheading" class="form-label">Sub Heading (Highlight)</label>
                        <input type="text" class="form-control" id="subheading" name="subheading" value="<?php echo isset($data['subheading']) ? $data['subheading'] : ''; ?>">
                    </div>
                    
                    <div class="col-12">
                        <label for="heading" class="form-label">Main Heading</label>
                        <input type="text" class="form-control" id="heading" name="heading" value="<?php echo isset($data['heading']) ? $data['heading'] : ''; ?>" required>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required><?php echo isset($data['description']) ? $data['description'] : ''; ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="button_text" class="form-label">Button Text</label>
                        <input type="text" class="form-control" id="button_text" name="button_text" value="<?php echo isset($data['button_text']) ? $data['button_text'] : ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="button_link" class="form-label">Button Link</label>
                        <input type="text" class="form-control" id="button_link" name="button_link" value="<?php echo isset($data['button_link']) ? $data['button_link'] : '#'; ?>">
                    </div>

                    <div class="col-12">
                        <label for="image" class="form-label">Image Path</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                            <input type="text" class="form-control" id="image" name="image" value="<?php echo isset($data['image']) ? $data['image'] : ''; ?>" placeholder="assets/images/...">
                        </div>
                        <small class="text-muted">Masukkan path gambar, contoh: <code>assets/images/about/02.png</code></small>
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

<!-- RichTextEditor JS & CSS -->
<link rel="stylesheet" href="richtexteditor/rte_theme_default.css" />
<script type="text/javascript" src="richtexteditor/rte.js"></script>
<script type="text/javascript" src='richtexteditor/plugins/all_plugins.js'></script>

<script>
    // Initialize RichTextEditor
    var editor1 = new RichTextEditor("#description");
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
</style>

<?php include 'includes/footer.php'; ?>
