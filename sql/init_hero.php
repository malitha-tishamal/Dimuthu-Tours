<?php
include 'e:/wamp/www/dimu-tours/Dimu Tours/includes/db.php';
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS hero_slides (id INT AUTO_INCREMENT PRIMARY KEY, image_path VARCHAR(255) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
    echo "hero_slides table created successfully.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
