<?php
require_once 'includes/db.php';

try {
    $sql = file_get_contents('schema.sql');
    $pdo->exec($sql);
    
    // Insert seed data if empty
    $count = $pdo->query("SELECT COUNT(*) FROM tours")->fetchColumn();
    if($count == 0) {
        $pdo->exec("INSERT INTO tours (title, description, duration, image) VALUES 
        ('Cultural Tours', 'Explore Sigiriya Rock, Ancient Cities, and Temples.', '5 Days / 4 Nights', 'https://images.unsplash.com/photo-1570654230464-9e0fa236d338?q=80&w=600'),
        ('Wildlife Safari', 'Experience Yala and Udawalawe National Parks.', '3 Days / 2 Nights', 'https://images.unsplash.com/photo-1549366021-9f761d450615?q=80&w=600'),
        ('Beach Getaways', 'Relax at the beautiful Southern beaches of Sri Lanka.', '4 Days / 3 Nights', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=600')");
    }
    
    $r_count = $pdo->query("SELECT COUNT(*) FROM reviews")->fetchColumn();
    if($r_count == 0) {
        $pdo->exec("INSERT INTO reviews (name, country, rating, message, status) VALUES 
        ('Sarah M.', 'UK', 5, 'Amazing experience! Dimu Tours made our trip unforgettable.', 'approved'),
        ('Jason D.', 'Germany', 5, 'Excellent service and great adventures! Highly recommend.', 'approved')");
    }

    echo "Database setup complete.";
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
