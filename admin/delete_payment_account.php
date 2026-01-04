<?php
require_once 'auth_check.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Get account data
    $stmt = $pdo->prepare("SELECT icon FROM payment_accounts WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $account = $stmt->fetch();
    
    if ($account) {
        // Delete icon file
        if (!empty($account['icon']) && file_exists('../' . $account['icon'])) {
            unlink('../' . $account['icon']);
        }
        
        // Delete from database
        $stmt = $pdo->prepare("DELETE FROM payment_accounts WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        header('Location: manage_payment_accounts.php?status=deleted');
    } else {
        header('Location: manage_payment_accounts.php?status=error');
    }
} else {
    header('Location: manage_payment_accounts.php');
}
exit;
?>
