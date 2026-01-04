<?php
require_once 'auth_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        // Add new feature
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $button_text = $_POST['button_text'] ?? 'Read More';
        $button_link = $_POST['button_link'] ?? '#';
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = (int)($_POST['is_active'] ?? 1);
        
        // Handle image upload
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploadDir = '../assets/images/feature/icon/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = 'feature_' . time() . '_' . uniqid() . '.' . $extension;
            $targetPath = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = 'assets/images/feature/icon/' . $filename;
            }
        }
        
        // Insert into database
        $stmt = $pdo->prepare("
            INSERT INTO features (title, description, image, button_text, button_link, display_order, is_active)
            VALUES (:title, :description, :image, :button_text, :button_link, :display_order, :is_active)
        ");
        
        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'image' => $imagePath,
            'button_text' => $button_text,
            'button_link' => $button_link,
            'display_order' => $display_order,
            'is_active' => $is_active
        ]);
        
        header('Location: manage_features.php?status=success');
        exit;
        
    } elseif ($action === 'edit') {
        // Edit existing feature
        $id = (int)$_POST['id'];
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $button_text = $_POST['button_text'] ?? '';
        $button_link = $_POST['button_link'] ?? '';
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = (int)($_POST['is_active'] ?? 1);
        
        // Get current feature data
        $stmt = $pdo->prepare("SELECT image FROM features WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $current = $stmt->fetch();
        
        $imagePath = $current['image'];
        
        // Handle new image upload if provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploadDir = '../assets/images/feature/icon/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Delete old image
            if (!empty($current['image']) && file_exists('../' . $current['image'])) {
                unlink('../' . $current['image']);
            }
            
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = 'feature_' . time() . '_' . uniqid() . '.' . $extension;
            $targetPath = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = 'assets/images/feature/icon/' . $filename;
            }
        }
        
        // Update database
        $stmt = $pdo->prepare("
            UPDATE features 
            SET title = :title, description = :description, image = :image, 
                button_text = :button_text, button_link = :button_link, 
                display_order = :display_order, is_active = :is_active
            WHERE id = :id
        ");
        
        $stmt->execute([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'image' => $imagePath,
            'button_text' => $button_text,
            'button_link' => $button_link,
            'display_order' => $display_order,
            'is_active' => $is_active
        ]);
        
        header('Location: manage_features.php?status=updated');
        exit;
    }
}

header('Location: manage_features.php');
exit;
?>
