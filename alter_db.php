<?php
require_once 'includes/db.php';
try {
    $pdo->exec("ALTER TABLE tours ADD COLUMN status ENUM('active', 'disabled') DEFAULT 'active' AFTER image");
    echo "Success";
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
