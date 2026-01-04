<?php
require_once 'auth_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        // Add new service
        $title = $_POST['title'] ?? '';
        $subtitle = $_POST['subtitle'] ?? '';
        $description = $_POST['description'] ?? '';
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = (int)($_POST['is_active'] ?? 1);
        
        // Handle main image from base64
        $imagePath = '';
        if (!empty($_POST['cropped_main_image'])) {
            $data = $_POST['cropped_main_image'];
            
            // Remove the data:image/png;base64, part
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $imageData = base64_decode($image_array_2[1]);
            
            // Ensure directory exists
            $uploadDir = '../assets/images/services/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Generate filename
            $filename = 'service_' . time() . '_' . uniqid() . '.png';
            $targetPath = $uploadDir . $filename;
            
            if (file_put_contents($targetPath, $imageData)) {
                $imagePath = 'assets/images/services/' . $filename;
            }
        }
        
        // Handle icon from base64
        $iconPath = '';
        if (!empty($_POST['cropped_icon'])) {
            $data = $_POST['cropped_icon'];
            
            // Remove the data:image/png;base64, part
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $iconData = base64_decode($image_array_2[1]);
            
            // Ensure directory exists
            $uploadDir = '../assets/images/services/icon/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Generate filename
            $filename = 'icon_' . time() . '_' . uniqid() . '.png';
            $targetPath = $uploadDir . $filename;
            
            if (file_put_contents($targetPath, $iconData)) {
                $iconPath = 'assets/images/services/icon/' . $filename;
            }
        }
        
        // Insert into database
        if (!empty($imagePath) && !empty($iconPath)) {
            $stmt = $pdo->prepare("
                INSERT INTO services (title, subtitle, description, image, icon, display_order, is_active)
                VALUES (:title, :subtitle, :description, :image, :icon, :display_order, :is_active)
            ");
            
            $stmt->execute([
                'title' => $title,
                'subtitle' => $subtitle,
                'description' => $description,
                'image' => $imagePath,
                'icon' => $iconPath,
                'display_order' => $display_order,
                'is_active' => $is_active
            ]);
            
            header('Location: manage_services.php?status=success');
            exit;
        } else {
            header('Location: manage_services.php?status=error&msg=image_required');
            exit;
        }
        
    } elseif ($action === 'edit') {
        // Edit existing service
        $id = (int)$_POST['id'];
        $title = $_POST['title'] ?? '';
        $subtitle = $_POST['subtitle'] ?? '';
        $description = $_POST['description'] ?? '';
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = (int)($_POST['is_active'] ?? 1);
        
        // Get current service data
        $stmt = $pdo->prepare("SELECT image, icon FROM services WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $current = $stmt->fetch();
        
        $imagePath = $current['image'];
        $iconPath = $current['icon'];
        
        // Handle new main image if provided
        if (!empty($_POST['cropped_main_image'])) {
            $data = $_POST['cropped_main_image'];
            
            // Remove the data:image/png;base64, part
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $imageData = base64_decode($image_array_2[1]);
            
            // Ensure directory exists
            $uploadDir = '../assets/images/services/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Delete old image
            if (!empty($current['image']) && file_exists('../' . $current['image'])) {
                unlink('../' . $current['image']);
            }
            
            // Generate filename
            $filename = 'service_' . time() . '_' . uniqid() . '.png';
            $targetPath = $uploadDir . $filename;
            
            if (file_put_contents($targetPath, $imageData)) {
                $imagePath = 'assets/images/services/' . $filename;
            }
        }
        
        // Handle new icon if provided
        if (!empty($_POST['cropped_icon'])) {
            $data = $_POST['cropped_icon'];
            
            // Remove the data:image/png;base64, part
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $iconData = base64_decode($image_array_2[1]);
            
            // Ensure directory exists
            $uploadDir = '../assets/images/services/icon/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Delete old icon
            if (!empty($current['icon']) && file_exists('../' . $current['icon'])) {
                unlink('../' . $current['icon']);
            }
            
            // Generate filename
            $filename = 'icon_' . time() . '_' . uniqid() . '.png';
            $targetPath = $uploadDir . $filename;
            
            if (file_put_contents($targetPath, $iconData)) {
                $iconPath = 'assets/images/services/icon/' . $filename;
            }
        }
        
        // Update database
        $stmt = $pdo->prepare("
            UPDATE services 
            SET title = :title, subtitle = :subtitle, description = :description, 
                image = :image, icon = :icon, display_order = :display_order, is_active = :is_active
            WHERE id = :id
        ");
        
        $stmt->execute([
            'id' => $id,
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $description,
            'image' => $imagePath,
            'icon' => $iconPath,
            'display_order' => $display_order,
            'is_active' => $is_active
        ]);
        
        header('Location: manage_services.php?status=updated');
        exit;
    }
}

header('Location: manage_services.php');
exit;
?>
