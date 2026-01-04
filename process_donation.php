<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $donor_name = $_POST['donor_name'] ?? '';
    $donor_email = $_POST['donor_email'] ?? '';
    $donor_phone = $_POST['donor_phone'] ?? '';
    $payment_account_id = (int)($_POST['payment_account_id'] ?? 0);
    $amount = (float)($_POST['amount'] ?? 0);
    $message = $_POST['message'] ?? '';
    
    // Validate required fields
    if (empty($donor_name) || empty($donor_phone) || $payment_account_id === 0 || $amount <= 0) {
        header('Location: donate.php?status=error&msg=required_fields');
        exit;
    }
    
    // Handle payment proof upload
    $paymentProofPath = '';
    if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === 0) {
        $uploadDir = 'assets/images/donations/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $fileType = $_FILES['payment_proof']['type'];
        
        if (!in_array($fileType, $allowedTypes)) {
            header('Location: donate.php?status=error&msg=invalid_file_type');
            exit;
        }
        
        // Validate file size (max 5MB)
        if ($_FILES['payment_proof']['size'] > 5 * 1024 * 1024) {
            header('Location: donate.php?status=error&msg=file_too_large');
            exit;
        }
        
        $extension = pathinfo($_FILES['payment_proof']['name'], PATHINFO_EXTENSION);
        $filename = 'proof_' . time() . '_' . uniqid() . '.' . $extension;
        $targetPath = $uploadDir . $filename;
        
        if (move_uploaded_file($_FILES['payment_proof']['tmp_name'], $targetPath)) {
            $paymentProofPath = $targetPath;
        } else {
            header('Location: donate.php?status=error&msg=upload_failed');
            exit;
        }
    } else {
        header('Location: donate.php?status=error&msg=proof_required');
        exit;
    }
    
    // Insert donation data
    try {
        $stmt = $pdo->prepare("
            INSERT INTO donations 
            (donor_name, donor_email, donor_phone, payment_account_id, amount, payment_proof, message, status, created_at)
            VALUES 
            (:donor_name, :donor_email, :donor_phone, :payment_account_id, :amount, :payment_proof, :message, 'pending', NOW())
        ");
        
        $stmt->execute([
            'donor_name' => $donor_name,
            'donor_email' => $donor_email,
            'donor_phone' => $donor_phone,
            'payment_account_id' => $payment_account_id,
            'amount' => $amount,
            'payment_proof' => $paymentProofPath,
            'message' => $message
        ]);
        
        // Success - redirect with success message
        header('Location: donate.php?status=success');
        exit;
        
    } catch (PDOException $e) {
        // Error - log and redirect
        error_log("Donation insert error: " . $e->getMessage());
        header('Location: donate.php?status=error&msg=database_error');
        exit;
    }
} else {
    // Not a POST request
    header('Location: index.php');
    exit;
}
?>
