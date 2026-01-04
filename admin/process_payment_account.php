<?php
require_once 'auth_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        // Add new payment account
        $bank_name = $_POST['bank_name'] ?? '';
        $account_type = $_POST['account_type'] ?? 'bank';
        $account_number = $_POST['account_number'] ?? '';
        $account_name = $_POST['account_name'] ?? '';
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = (int)($_POST['is_active'] ?? 1);
        
        // Handle icon upload
        $iconPath = '';
        if (isset($_FILES['icon']) && $_FILES['icon']['error'] === 0) {
            $uploadDir = '../assets/images/payment/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $extension = pathinfo($_FILES['icon']['name'], PATHINFO_EXTENSION);
            $filename = 'payment_' . time() . '_' . uniqid() . '.' . $extension;
            $targetPath = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['icon']['tmp_name'], $targetPath)) {
                $iconPath = 'assets/images/payment/' . $filename;
            }
        }
        
        // Insert into database
        $stmt = $pdo->prepare("
            INSERT INTO payment_accounts (bank_name, account_number, account_name, account_type, icon, display_order, is_active)
            VALUES (:bank_name, :account_number, :account_name, :account_type, :icon, :display_order, :is_active)
        ");
        
        $stmt->execute([
            'bank_name' => $bank_name,
            'account_number' => $account_number,
            'account_name' => $account_name,
            'account_type' => $account_type,
            'icon' => $iconPath,
            'display_order' => $display_order,
            'is_active' => $is_active
        ]);
        
        header('Location: manage_payment_accounts.php?status=success');
        exit;
        
    } elseif ($action === 'edit') {
        // Edit existing payment account
        $id = (int)$_POST['id'];
        $bank_name = $_POST['bank_name'] ?? '';
        $account_type = $_POST['account_type'] ?? 'bank';
        $account_number = $_POST['account_number'] ?? '';
        $account_name = $_POST['account_name'] ?? '';
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = (int)($_POST['is_active'] ?? 1);
        
        // Get current data
        $stmt = $pdo->prepare("SELECT icon FROM payment_accounts WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $current = $stmt->fetch();
        
        $iconPath = $current['icon'] ?? '';
        
        // Handle new icon if provided
        if (isset($_FILES['icon']) && $_FILES['icon']['error'] === 0) {
            $uploadDir = '../assets/images/payment/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Delete old icon
            if (!empty($current['icon']) && file_exists('../' . $current['icon'])) {
                unlink('../' . $current['icon']);
            }
            
            $extension = pathinfo($_FILES['icon']['name'], PATHINFO_EXTENSION);
            $filename = 'payment_' . time() . '_' . uniqid() . '.' . $extension;
            $targetPath = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['icon']['tmp_name'], $targetPath)) {
                $iconPath = 'assets/images/payment/' . $filename;
            }
        }
        
        // Update database
        $stmt = $pdo->prepare("
            UPDATE payment_accounts 
            SET bank_name = :bank_name, account_number = :account_number, account_name = :account_name,
                account_type = :account_type, icon = :icon, display_order = :display_order, is_active = :is_active
            WHERE id = :id
        ");
        
        $stmt->execute([
            'id' => $id,
            'bank_name' => $bank_name,
            'account_number' => $account_number,
            'account_name' => $account_name,
            'account_type' => $account_type,
            'icon' => $iconPath,
            'display_order' => $display_order,
            'is_active' => $is_active
        ]);
        
        header('Location: manage_payment_accounts.php?status=updated');
        exit;
    }
}

header('Location: manage_payment_accounts.php');
exit;
?>
