<?php
require_once 'auth_check.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Get service data
    $stmt = $pdo->prepare("SELECT image, icon FROM services WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $service = $stmt->fetch();
    
    if ($service) {
        // Delete main image file
        if (!empty($service['image']) && file_exists('../' . $service['image'])) {
            unlink('../' . $service['image']);
        }
        
        // Delete icon file
        if (!empty($service['icon']) && file_exists('../' . $service['icon'])) {
            unlink('../' . $service['icon']);
        }
        
        // Delete from database
        $stmt = $pdo->prepare("DELETE FROM services WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        header('Location: manage_services.php?status=deleted');
    } else {
        header('Location: manage_services.php?status=error');
    }
} else {
    header('Location: manage_services.php');
}
exit;
?>
