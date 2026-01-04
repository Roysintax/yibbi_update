<?php
require_once 'auth_check.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $stmt = $pdo->prepare("SELECT * FROM services WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $service = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($service) {
        header('Content-Type: application/json');
        echo json_encode($service);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Service not found']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID not provided']);
}
?>
