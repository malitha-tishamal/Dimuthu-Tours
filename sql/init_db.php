<?php
include 'e:/wamp/www/dimu-tours/Dimu Tours/includes/db.php';
$sql = file_get_contents('e:/wamp/www/dimu-tours/Dimu Tours/sql/travel_memories.sql');
try {
    $pdo->exec($sql);
    echo "Tables created successfully.\n";
} catch (PDOException $e) {
    echo "Error creating tables: " . $e->getMessage() . "\n";
}
?>
