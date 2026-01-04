<?php
require_once 'config/database.php';
$stmt = $pdo->query("SELECT description FROM about_history LIMIT 1");
$data = $stmt->fetch();
echo "<h1>Raw Data Debug</h1>";
echo "<pre>";
var_dump($data['description']);
echo "</pre>";
?>
