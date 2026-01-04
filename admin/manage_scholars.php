<?php
require_once 'auth_check.php';
require_once '../config/database.php';

// Handle Delete Request
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM scholars WHERE id = ?");
    if ($stmt->execute([$id])) {
        $_SESSION['success'] = "Scholar deleted successfully.";
    } else {
        $_SESSION['error'] = "Failed to delete scholar.";
    }
    header("Location: manage_scholars.php");
    exit;
}

// Handle Form Submission (Add/Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $name = trim($_POST['name']);
    $title = trim($_POST['title']);
    $bio = trim($_POST['bio']);
    $personal_statement = trim($_POST['personal_statement']);
    $scholar_address = trim($_POST['scholar_address']);
    $scholar_email = trim($_POST['scholar_email']);
    $scholar_phone = trim($_POST['scholar_phone']);
    $website = trim($_POST['website']);
    $social_twitter = trim($_POST['social_twitter']) ?: '#';
    $social_behance = trim($_POST['social_behance']) ?: '#';
    $social_instagram = trim($_POST['social_instagram']) ?: '#';
    $social_vimeo = trim($_POST['social_vimeo']) ?: '#';
    $social_linkedin = trim($_POST['social_linkedin']) ?: '#';
    $display_order = (int)$_POST['display_order'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    // Handle language skills JSON
    $language_skills = [];
    if (!empty($_POST['skill_name'])) {
        foreach ($_POST['skill_name'] as $i => $skillName) {
            if (!empty($skillName)) {
                $language_skills[] = [
                    'name' => $skillName,
                    'percent' => (int)($_POST['skill_percent'][$i] ?? 50)
                ];
            }
        }
    }
    $language_skills_json = json_encode($language_skills);

    // Handle awards JSON
    $awards = [];
    if (!empty($_POST['award_year'])) {
        foreach ($_POST['award_year'] as $i => $year) {
            if (!empty($year)) {
                $awards[] = [
                    'image' => $_POST['award_image'][$i] ?? 'assets/images/team/award/01.png',
                    'year' => $year
                ];
            }
        }
    }
    $awards_json = json_encode($awards);

    // Handle Image Upload
    $imagePath = $_POST['current_image'] ?? '';
    $detailImagePath = $_POST['current_detail_image'] ?? '';

    if (!empty($_POST['cropped_image'])) {
        $data = $_POST['cropped_image'];
        $image_array_1 = explode(";", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $imageName = 'scholar_' . time() . '.png';
        $imagePath = 'assets/images/team/' . $imageName;
        file_put_contents('../' . $imagePath, $data);
    }

    if (!empty($_POST['cropped_detail_image'])) {
        $data = $_POST['cropped_detail_image'];
        $image_array_1 = explode(";", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $imageName = 'scholar_detail_' . time() . '.png';
        $detailImagePath = 'assets/images/team/' . $imageName;
        file_put_contents('../' . $detailImagePath, $data);
    }

    try {
        if ($id > 0) {
            $sql = "UPDATE scholars SET 
                    name = ?, title = ?, image = ?, detail_image = ?, bio = ?, personal_statement = ?,
                    scholar_address = ?, scholar_email = ?, scholar_phone = ?, website = ?,
                    language_skills = ?, awards = ?,
                    social_twitter = ?, social_behance = ?, social_instagram = ?, social_vimeo = ?, social_linkedin = ?,
                    display_order = ?, is_active = ?
                    WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $title, $imagePath, $detailImagePath, $bio, $personal_statement,
                           $scholar_address, $scholar_email, $scholar_phone, $website,
                           $language_skills_json, $awards_json,
                           $social_twitter, $social_behance, $social_instagram, $social_vimeo, $social_linkedin,
                           $display_order, $is_active, $id]);
            $_SESSION['success'] = "Scholar updated successfully.";
        } else {
            $sql = "INSERT INTO scholars (name, title, image, detail_image, bio, personal_statement,
                    scholar_address, scholar_email, scholar_phone, website,
                    language_skills, awards,
                    social_twitter, social_behance, social_instagram, social_vimeo, social_linkedin,
                    display_order, is_active) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $title, $imagePath, $detailImagePath, $bio, $personal_statement,
                           $scholar_address, $scholar_email, $scholar_phone, $website,
                           $language_skills_json, $awards_json,
                           $social_twitter, $social_behance, $social_instagram, $social_vimeo, $social_linkedin,
                           $display_order, $is_active]);
            $_SESSION['success'] = "Scholar created successfully.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }

    header("Location: manage_scholars.php");
    exit;
}

// Fetch all scholars
$scholars = $pdo->query("SELECT * FROM scholars ORDER BY display_order ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Scholars - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .image-preview { max-width: 100px; height: 100px; object-fit: cover; border-radius: 8px; }
        .skill-row, .award-row { background: #f8f9fa; padding: 10px; border-radius: 8px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <?php include 'includes/sidebar.php'; ?>

        <div id="page-content-wrapper" class="w-100">
            <?php include 'includes/header.php'; ?>

            <div class="container-fluid px-4 py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0"><i class="fas fa-user-graduate me-2"></i>Manage Scholars</h2>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#scholarModal" onclick="resetForm()">
                        <i class="fas fa-plus"></i> Add New Scholar
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
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($scholars as $scholar): ?>
                                    <tr>
                                        <td>
                                            <img src="../<?php echo htmlspecialchars($scholar['image'] ?: 'assets/images/team/01.jpg'); ?>" 
                                                 class="image-preview" alt="<?php echo htmlspecialchars($scholar['name']); ?>">
                                        </td>
                                        <td><strong><?php echo htmlspecialchars($scholar['name']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($scholar['title']); ?></td>
                                        <td><?php echo $scholar['display_order']; ?></td>
                                        <td>
                                            <?php if ($scholar['is_active']): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info text-white me-1" 
                                                    onclick='editScholar(<?php echo json_encode($scholar); ?>)'>
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="?delete=<?php echo $scholar['id']; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Are you sure you want to delete this scholar?')">
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

    <!-- Scholar Modal -->
    <div class="modal fade" id="scholarModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add New Scholar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="scholarForm" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="scholar_id">
                        <input type="hidden" name="current_image" id="current_image">
                        <input type="hidden" name="current_detail_image" id="current_detail_image">
                        <input type="hidden" name="cropped_image" id="cropped_image">
                        <input type="hidden" name="cropped_detail_image" id="cropped_detail_image">

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-user me-2"></i>Basic Info</h6>
                                <div class="mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" class="form-control" name="name" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Title *</label>
                                    <input type="text" class="form-control" name="title" id="title" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Bio (Short Intro)</label>
                                    <textarea class="form-control" name="bio" id="bio" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Personal Statement</label>
                                    <textarea class="form-control" name="personal_statement" id="personal_statement" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-address-card me-2"></i>Contact Info</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" name="scholar_address" id="scholar_address">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="scholar_email" id="scholar_email">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="scholar_phone" id="scholar_phone">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Website</label>
                                        <input type="text" class="form-control" name="website" id="website">
                                    </div>
                                </div>
                                <h6 class="border-bottom pb-2 mb-3 mt-3"><i class="fas fa-share-alt me-2"></i>Social Media</h6>
                                <div class="row">
                                    <div class="col-6 mb-2">
                                        <input type="text" class="form-control form-control-sm" name="social_twitter" id="social_twitter" placeholder="Twitter URL">
                                    </div>
                                    <div class="col-6 mb-2">
                                        <input type="text" class="form-control form-control-sm" name="social_instagram" id="social_instagram" placeholder="Instagram URL">
                                    </div>
                                    <div class="col-6 mb-2">
                                        <input type="text" class="form-control form-control-sm" name="social_linkedin" id="social_linkedin" placeholder="LinkedIn URL">
                                    </div>
                                    <div class="col-6 mb-2">
                                        <input type="text" class="form-control form-control-sm" name="social_behance" id="social_behance" placeholder="Behance URL">
                                    </div>
                                    <div class="col-6 mb-2">
                                        <input type="text" class="form-control form-control-sm" name="social_vimeo" id="social_vimeo" placeholder="Vimeo URL">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-image me-2"></i>Card Image (small)</h6>
                                <input type="file" class="form-control mb-2" id="imageInput" accept="image/*">
                                <div id="imagePreview"></div>
                            </div>
                            <div class="col-md-4">
                                <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-image me-2"></i>Detail Image (large)</h6>
                                <input type="file" class="form-control mb-2" id="detailImageInput" accept="image/*">
                                <div id="detailImagePreview"></div>
                            </div>
                            <div class="col-md-4">
                                <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-cog me-2"></i>Settings</h6>
                                <div class="mb-3">
                                    <label class="form-label">Display Order</label>
                                    <input type="number" class="form-control" name="display_order" id="display_order" value="0">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_active" id="is_active" checked>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-language me-2"></i>Language Skills</h6>
                                <div id="skillsContainer">
                                    <div class="skill-row d-flex gap-2 align-items-center">
                                        <input type="text" class="form-control" name="skill_name[]" placeholder="Language">
                                        <input type="number" class="form-control" name="skill_percent[]" placeholder="%" min="0" max="100" style="width:100px">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addSkillRow()">
                                    <i class="fas fa-plus"></i> Add Skill
                                </button>
                            </div>
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-trophy me-2"></i>Awards</h6>
                                <div id="awardsContainer">
                                    <div class="award-row d-flex gap-2 align-items-center">
                                        <input type="text" class="form-control" name="award_year[]" placeholder="Award Year/Title">
                                        <input type="text" class="form-control" name="award_image[]" placeholder="Image Path" value="assets/images/team/award/01.png">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addAwardRow()">
                                    <i class="fas fa-plus"></i> Add Award
                                </button>
                            </div>
                        </div>

                        <div class="modal-footer px-0 pb-0 mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Scholar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    
    <script>
    // Simple image preview (without cropper for simplicity)
    document.getElementById('imageInput').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded mt-2" style="max-height:150px">';
                document.getElementById('cropped_image').value = e.target.result;
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    document.getElementById('detailImageInput').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('detailImagePreview').innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded mt-2" style="max-height:150px">';
                document.getElementById('cropped_detail_image').value = e.target.result;
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    function addSkillRow() {
        const container = document.getElementById('skillsContainer');
        container.innerHTML += `
            <div class="skill-row d-flex gap-2 align-items-center">
                <input type="text" class="form-control" name="skill_name[]" placeholder="Language">
                <input type="number" class="form-control" name="skill_percent[]" placeholder="%" min="0" max="100" style="width:100px">
                <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>`;
    }

    function addAwardRow() {
        const container = document.getElementById('awardsContainer');
        container.innerHTML += `
            <div class="award-row d-flex gap-2 align-items-center">
                <input type="text" class="form-control" name="award_year[]" placeholder="Award Year/Title">
                <input type="text" class="form-control" name="award_image[]" placeholder="Image Path" value="assets/images/team/award/01.png">
                <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>`;
    }

    function resetForm() {
        document.getElementById('scholarForm').reset();
        document.getElementById('scholar_id').value = '';
        document.getElementById('modalTitle').innerText = 'Add New Scholar';
        document.getElementById('current_image').value = '';
        document.getElementById('current_detail_image').value = '';
        document.getElementById('cropped_image').value = '';
        document.getElementById('cropped_detail_image').value = '';
        document.getElementById('imagePreview').innerHTML = '';
        document.getElementById('detailImagePreview').innerHTML = '';
        document.getElementById('skillsContainer').innerHTML = `
            <div class="skill-row d-flex gap-2 align-items-center">
                <input type="text" class="form-control" name="skill_name[]" placeholder="Language">
                <input type="number" class="form-control" name="skill_percent[]" placeholder="%" min="0" max="100" style="width:100px">
                <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>`;
        document.getElementById('awardsContainer').innerHTML = `
            <div class="award-row d-flex gap-2 align-items-center">
                <input type="text" class="form-control" name="award_year[]" placeholder="Award Year/Title">
                <input type="text" class="form-control" name="award_image[]" placeholder="Image Path" value="assets/images/team/award/01.png">
                <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>`;
    }

    function editScholar(scholar) {
        resetForm();
        document.getElementById('scholar_id').value = scholar.id;
        document.getElementById('name').value = scholar.name;
        document.getElementById('title').value = scholar.title;
        document.getElementById('bio').value = scholar.bio || '';
        document.getElementById('personal_statement').value = scholar.personal_statement || '';
        document.getElementById('scholar_address').value = scholar.scholar_address || '';
        document.getElementById('scholar_email').value = scholar.scholar_email || '';
        document.getElementById('scholar_phone').value = scholar.scholar_phone || '';
        document.getElementById('website').value = scholar.website || '';
        document.getElementById('social_twitter').value = scholar.social_twitter || '#';
        document.getElementById('social_behance').value = scholar.social_behance || '#';
        document.getElementById('social_instagram').value = scholar.social_instagram || '#';
        document.getElementById('social_vimeo').value = scholar.social_vimeo || '#';
        document.getElementById('social_linkedin').value = scholar.social_linkedin || '#';
        document.getElementById('display_order').value = scholar.display_order || 0;
        document.getElementById('is_active').checked = scholar.is_active == 1;
        document.getElementById('current_image').value = scholar.image || '';
        document.getElementById('current_detail_image').value = scholar.detail_image || '';

        if (scholar.image) {
            document.getElementById('imagePreview').innerHTML = '<img src="../' + scholar.image + '" class="img-fluid rounded mt-2" style="max-height:150px">';
        }
        if (scholar.detail_image) {
            document.getElementById('detailImagePreview').innerHTML = '<img src="../' + scholar.detail_image + '" class="img-fluid rounded mt-2" style="max-height:150px">';
        }

        // Load language skills
        let skills = [];
        try { skills = JSON.parse(scholar.language_skills || '[]'); } catch(e) {}
        let skillsHtml = '';
        skills.forEach(skill => {
            skillsHtml += `
                <div class="skill-row d-flex gap-2 align-items-center">
                    <input type="text" class="form-control" name="skill_name[]" placeholder="Language" value="${skill.name}">
                    <input type="number" class="form-control" name="skill_percent[]" placeholder="%" min="0" max="100" style="width:100px" value="${skill.percent}">
                    <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                </div>`;
        });
        if (skillsHtml === '') {
            skillsHtml = `<div class="skill-row d-flex gap-2 align-items-center">
                <input type="text" class="form-control" name="skill_name[]" placeholder="Language">
                <input type="number" class="form-control" name="skill_percent[]" placeholder="%" min="0" max="100" style="width:100px">
                <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>`;
        }
        document.getElementById('skillsContainer').innerHTML = skillsHtml;

        // Load awards
        let awards = [];
        try { awards = JSON.parse(scholar.awards || '[]'); } catch(e) {}
        let awardsHtml = '';
        awards.forEach(award => {
            awardsHtml += `
                <div class="award-row d-flex gap-2 align-items-center">
                    <input type="text" class="form-control" name="award_year[]" placeholder="Award Year/Title" value="${award.year}">
                    <input type="text" class="form-control" name="award_image[]" placeholder="Image Path" value="${award.image}">
                    <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                </div>`;
        });
        if (awardsHtml === '') {
            awardsHtml = `<div class="award-row d-flex gap-2 align-items-center">
                <input type="text" class="form-control" name="award_year[]" placeholder="Award Year/Title">
                <input type="text" class="form-control" name="award_image[]" placeholder="Image Path" value="assets/images/team/award/01.png">
                <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>`;
        }
        document.getElementById('awardsContainer').innerHTML = awardsHtml;

        document.getElementById('modalTitle').innerText = 'Edit Scholar';
        var modal = new bootstrap.Modal(document.getElementById('scholarModal'));
        modal.show();
    }
    </script>
</body>
</html>
