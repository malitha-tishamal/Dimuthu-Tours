<?php
include 'e:/wamp/www/dimu-tours/Dimu Tours/includes/db.php';
try {
    $pdo->exec("ALTER TABLE travel_memories ADD COLUMN status ENUM('active', 'disabled') DEFAULT 'active' AFTER event_date");
    echo "Column added successfully.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
