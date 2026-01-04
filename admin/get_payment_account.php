<?php
require_once 'auth_check.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $stmt = $pdo->prepare("SELECT * FROM payment_accounts WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($account) {
        header('Content-Type: application/json');
        echo json_encode($account);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Account not found']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID not provided']);
}
?>
