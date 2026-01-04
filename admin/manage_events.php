<?php
session_start();
require_once '../config/database.php';
require_once 'auth_check.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM events WHERE id = $id");
    header("Location: manage_events.php?deleted=1");
    exit;
}

// Handle Form Submission
$success_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $event_date = $conn->real_escape_string($_POST['event_date']);
    $location = $conn->real_escape_string($_POST['location']);
    $organizer = $conn->real_escape_string($_POST['organizer']);
    $category = $conn->real_escape_string($_POST['category']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Handle Image
    $image = $_POST['current_image'] ?? '';
    if (isset($_POST['cropped_image']) && !empty($_POST['cropped_image'])) {
        $cropped_data = $_POST['cropped_image'];
        $cropped_data = str_replace(['data:image/png;base64,', 'data:image/jpeg;base64,', ' '], ['', '', '+'], $cropped_data);
        $decoded_image = base64_decode($cropped_data);
        
        $upload_dir = '../assets/images/event/';
        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $filename = 'event_' . time() . '.png';
        if (file_put_contents($upload_dir . $filename, $decoded_image)) {
            $image = 'assets/images/event/' . $filename;
        }
    }
    
    if ($id > 0) {
        $sql = "UPDATE events SET title='$title', description='$description', image='$image', 
                event_date='$event_date', location='$location', organizer='$organizer', 
                category='$category', is_featured=$is_featured, is_active=$is_active WHERE id=$id";
    } else {
        $sql = "INSERT INTO events (title, description, image, event_date, location, organizer, category, is_featured, is_active) 
                VALUES ('$title', '$description', '$image', '$event_date', '$location', '$organizer', '$category', $is_featured, $is_active)";
    }
    
    if ($conn->query($sql)) {
        $success_message = $id > 0 ? 'Event updated!' : 'Event added!';
    }
}

if (isset($_GET['deleted'])) $success_message = 'Event deleted!';
$events = $conn->query("SELECT * FROM events ORDER BY event_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events - Admin</title>
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
        .table img { width: 80px; height: 60px; object-fit: cover; border-radius: 8px; }
        .image-preview { max-width: 200px; border-radius: 10px; border: 3px solid #667eea; }
    </style>
</head>
<body>
    <div class="d-flex">
        <?php include 'includes/sidebar.php'; ?>
        
        <div class="main-content flex-grow-1">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-calendar-alt me-2"></i>Manage Events</h2>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#eventModal" onclick="resetForm()">
                        <i class="fas fa-plus me-1"></i> Add Event
                    </button>
                </div>
                
                <?php if ($success_message): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-header"><h5 class="mb-0"><i class="fas fa-list me-2"></i>All Events</h5></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($event = $events->fetch_assoc()): ?>
                                    <tr>
                                        <td><img src="../<?php echo htmlspecialchars($event['image']); ?>" alt=""></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($event['title']); ?></strong>
                                            <?php if ($event['is_featured']): ?><span class="badge bg-warning ms-1">Featured</span><?php endif; ?>
                                        </td>
                                        <td><?php echo date('M d, Y H:i', strtotime($event['event_date'])); ?></td>
                                        <td><?php echo htmlspecialchars($event['location']); ?></td>
                                        <td><span class="badge bg-info"><?php echo htmlspecialchars($event['category']); ?></span></td>
                                        <td>
                                            <?php echo $event['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick='editEvent(<?php echo json_encode($event); ?>)'>
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="?delete=<?php echo $event['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
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
    
    <!-- Event Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <h5 class="modal-title"><i class="fas fa-calendar-alt me-2"></i><span id="modalTitle">Add Event</span></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="eventId">
                        <input type="hidden" name="current_image" id="currentImage">
                        <input type="hidden" name="cropped_image" id="croppedImage">
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="eventTitle" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Category</label>
                                <input type="text" class="form-control" name="category" id="eventCategory" placeholder="Charity, Education...">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="eventDescription" rows="3" required></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Event Date & Time</label>
                                <input type="datetime-local" class="form-control" name="event_date" id="eventDate" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" name="location" id="eventLocation">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Organizer</label>
                                <input type="text" class="form-control" name="organizer" id="eventOrganizer">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <div class="mb-2">
                                <img id="imagePreview" src="../assets/images/event/01.jpg" alt="Preview" class="image-preview">
                            </div>
                            <input type="file" class="form-control" id="imageInput" accept="image/*">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_featured" id="isFeatured">
                                    <label class="form-check-label" for="isFeatured">Featured Event</label>
                                </div>
                            </div>
                            <div class="col-md-6">
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
            document.getElementById('eventId').value = '';
            document.getElementById('eventTitle').value = '';
            document.getElementById('eventDescription').value = '';
            document.getElementById('eventDate').value = '';
            document.getElementById('eventLocation').value = '';
            document.getElementById('eventOrganizer').value = '';
            document.getElementById('eventCategory').value = '';
            document.getElementById('currentImage').value = '';
            document.getElementById('croppedImage').value = '';
            document.getElementById('imagePreview').src = '../assets/images/event/01.jpg';
            document.getElementById('isFeatured').checked = false;
            document.getElementById('isActive').checked = true;
            document.getElementById('modalTitle').textContent = 'Add Event';
        }
        
        function editEvent(event) {
            document.getElementById('eventId').value = event.id;
            document.getElementById('eventTitle').value = event.title;
            document.getElementById('eventDescription').value = event.description;
            document.getElementById('eventDate').value = event.event_date.replace(' ', 'T');
            document.getElementById('eventLocation').value = event.location || '';
            document.getElementById('eventOrganizer').value = event.organizer || '';
            document.getElementById('eventCategory').value = event.category || '';
            document.getElementById('currentImage').value = event.image;
            document.getElementById('imagePreview').src = '../' + event.image;
            document.getElementById('isFeatured').checked = event.is_featured == 1;
            document.getElementById('isActive').checked = event.is_active == 1;
            document.getElementById('modalTitle').textContent = 'Edit Event';
            new bootstrap.Modal(document.getElementById('eventModal')).show();
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
                const canvas = cropper.getCroppedCanvas({ width: 800, height: 450 });
                const base64 = canvas.toDataURL('image/png');
                document.getElementById('croppedImage').value = base64;
                document.getElementById('imagePreview').src = base64;
                bootstrap.Modal.getInstance(document.getElementById('cropModal')).hide();
            }
        }
    </script>
</body>
</html>
