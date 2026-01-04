<?php
// fix_users_db.php
require_once 'config/database.php';

try {
    // Check if table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    $exists = $stmt->fetch();

    if (!$exists) {
        $sql = "CREATE TABLE `users` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `username` varchar(50) NOT NULL,
          `email` varchar(100) NOT NULL,
          `password` varchar(255) NOT NULL,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          PRIMARY KEY (`id`),
          UNIQUE KEY `email` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        
        $pdo->exec($sql);
        
        // Insert default admin user
        // Password: password
        $defaultPass = password_hash('password', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute(['admin', 'admin@yibbi.com', $defaultPass]);
        
        echo "✅ Table 'users' created successfully with default admin user.<br>";
        echo "Default Login: admin / password<br>";
    } else {
        echo "ℹ️ Table 'users' already exists.<br>";
    }

    echo "Database update complete! You can delete this file now.";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
