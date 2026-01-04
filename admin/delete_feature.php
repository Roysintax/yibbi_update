<?php
require_once 'auth_check.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Get feature data
    $stmt = $pdo->prepare("SELECT image FROM features WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $feature = $stmt->fetch();
    
    if ($feature) {
        // Delete image file
        if (!empty($feature['image']) && file_exists('../' . $feature['image'])) {
            unlink('../' . $feature['image']);
        }
        
        // Delete from database
        $stmt = $pdo->prepare("DELETE FROM features WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        header('Location: manage_features.php?status=deleted');
    } else {
        header('Location: manage_features.php?status=error');
    }
} else {
    header('Location: manage_features.php');
}
exit;
?>
