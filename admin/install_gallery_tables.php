<?php
require_once '../config/database.php';

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create gallery_categories table
    $sql1 = "CREATE TABLE IF NOT EXISTS `gallery_categories` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(100) NOT NULL,
      `slug` varchar(100) NOT NULL,
      `display_order` int(11) DEFAULT 0,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    $pdo->exec($sql1);
    echo "Table 'gallery_categories' created successfully.<br>";

    // Insert default categories if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM gallery_categories");
    if ($stmt->fetchColumn() == 0) {
        $sqlInsert1 = "INSERT INTO `gallery_categories` (`name`, `slug`, `display_order`) VALUES
            ('All', '*', 0),
            ('Eid Ul-Adha', 'eid-ul-adha', 1),
            ('Ramadan', 'ramadan', 2),
            ('Eid Ul-Fitr', 'eid-ul-fitr', 3),
            ('Clothe', 'clothe', 4);";
        $pdo->exec($sqlInsert1);
        echo "Default data inserted into 'gallery_categories'.<br>";
    }

    // Create gallery_items table
    $sql2 = "CREATE TABLE IF NOT EXISTS `gallery_items` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `subtitle` varchar(255),
      `image` varchar(255) NOT NULL,
      `categories` text,
      `created_at` datetime DEFAULT current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $pdo->exec($sql2);
    echo "Table 'gallery_items' created successfully.<br>";

    // Insert sample items if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM gallery_items");
    if ($stmt->fetchColumn() == 0) {
        $sqlInsert2 = "INSERT INTO `gallery_items` (`title`, `subtitle`, `image`, `categories`) VALUES
        ('The Image Title Goes Here', 'Subtitle Here', 'assets/images/gallery/mason/01.jpg', 'eid-ul-adha eid-ul-fitr'),
        ('The Image Title Goes Here', 'Subtitle Here', 'assets/images/gallery/mason/02.jpg', 'ramadan clothe'),
        ('The Image Title Goes Here', 'Subtitle Here', 'assets/images/gallery/mason/03.jpg', 'eid-ul-adha'),
        ('The Image Title Goes Here', 'Subtitle Here', 'assets/images/gallery/mason/04.jpg', 'clothe eid-ul-fitr');";
        $pdo->exec($sqlInsert2);
        echo "Sample data inserted into 'gallery_items'.<br>";
    }
    
    echo "<br><strong>Database setup completed successfully!</strong> <a href='manage_gallery.php'>Go back to Manage Gallery</a>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
