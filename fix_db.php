<?php
// fix_db.php
require_once 'config/database.php';

try {
    // Check if column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM settings LIKE 'whatsapp_donation'");
    $exists = $stmt->fetch();

    if (!$exists) {
        $pdo->exec("ALTER TABLE settings ADD COLUMN whatsapp_donation VARCHAR(20) DEFAULT '6281234567890' AFTER footer_about_image");
        echo "✅ Column 'whatsapp_donation' added to 'settings' table successfully.<br>";
    } else {
        echo "ℹ️ Column 'whatsapp_donation' already exists.<br>";
    }

    echo "Everything is good! You can delete this file now.";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
