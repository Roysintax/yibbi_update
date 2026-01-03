<?php
require_once 'config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // First retrieve image path to delete file
    $stmt = $conn->prepare("SELECT image FROM banners WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = "../" . $row['image'];
        
        // Delete image file if it exists
        if (file_exists($imagePath) && $row['image'] != 'assets/images/banner/01.png') {
            unlink($imagePath);
        }
        
        // Delete database record
        $deleteStmt = $conn->prepare("DELETE FROM banners WHERE id = ?");
        $deleteStmt->bind_param("i", $id);
        
        if ($deleteStmt->execute()) {
            header("Location: manage_banners.php?status=deleted");
            exit;
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        header("Location: manage_banners.php");
        exit;
    }
} else {
    header("Location: manage_banners.php");
    exit;
}
?>
