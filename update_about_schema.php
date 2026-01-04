<?php
require_once 'config/database.php';

try {
    // Add button_text column
    $sql = "ALTER TABLE about_history ADD COLUMN button_text varchar(50) DEFAULT 'Read More'";
    $pdo->exec($sql);
    echo "Added button_text column successfully.<br>";

    // Add button_link column
    $sql = "ALTER TABLE about_history ADD COLUMN button_link varchar(255) DEFAULT '#'";
    $pdo->exec($sql);
    echo "Added button_link column successfully.<br>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
