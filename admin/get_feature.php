<?php
require_once 'auth_check.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $stmt = $pdo->prepare("SELECT * FROM features WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $feature = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($feature) {
        header('Content-Type: application/json');
        echo json_encode($feature);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Feature not found']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID not provided']);
}
?>
