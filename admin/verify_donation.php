<?php
require_once 'auth_check.php';

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];
    
    if ($action === 'verify') {
        $stmt = $pdo->prepare("
            UPDATE donations 
            SET status = 'verified', verified_at = NOW()
            WHERE id = :id
        ");
        $stmt->execute(['id' => $id]);
        header('Location: manage_donations.php?status=verified');
        exit;
        
    } elseif ($action === 'reject') {
        $stmt = $pdo->prepare("
            UPDATE donations 
            SET status = 'rejected', verified_at = NOW()
            WHERE id = :id
        ");
        $stmt->execute(['id' => $id]);
        header('Location: manage_donations.php?status=rejected');
        exit;
    }
}

header('Location: manage_donations.php');
exit;
?>
