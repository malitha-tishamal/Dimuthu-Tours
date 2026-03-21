<?php
require_once 'includes/db.php';
try {
    // 1. Create table
    $sql = "CREATE TABLE IF NOT EXISTS safari_destinations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        image VARCHAR(255),
        status ENUM('active', 'disabled') DEFAULT 'active'
    )";
    $pdo->exec($sql);
    
    // 2. Clear existing (if any) to avoid duplicates during migration
    $pdo->exec("TRUNCATE TABLE safari_destinations");

    // 3. Populate with initial data
    $safaris = [
        [
            'title' => 'Yala National Park',
            'desc' => 'Yala is the most famous national park in Sri Lanka, known for having one of the highest densities of leopards in the world. Visitors can also see elephants, crocodiles, sloth bears, and a wide variety of birds. Perfect for an exciting and adventurous safari experience.',
            'image' => 'assets/yala.png'
        ],
        [
            'title' => 'Udawalawe National Park',
            'desc' => 'Udawalawe is the best place to see large herds of elephants in their natural habitat. The park offers open landscapes, making wildlife easy to spot. A great destination for families and nature lovers.',
            'image' => 'assets/udawalawe.png'
        ],
        [
            'title' => 'Wilpattu National Park',
            'desc' => 'Wilpattu is Sri Lanka’s largest national park, famous for its natural lakes (villus) and peaceful environment. It is home to leopards, deer, elephants, and many bird species. Ideal for those who prefer a quiet and less crowded safari.',
            'image' => 'assets/wilpattu.png'
        ],
        [
            'title' => 'Minneriya National Park',
            'desc' => 'Minneriya is world-famous for “The Gathering,” where hundreds of elephants come together around the reservoir during the dry season. This is one of the greatest wildlife spectacles in Asia.',
            'image' => 'assets/minneriya.png'
        ],
        [
            'title' => 'Kaudulla National Park',
            'desc' => 'Kaudulla is another excellent place to see elephants and diverse birdlife. It is often combined with Minneriya for a complete safari experience.',
            'image' => 'assets/kaudulla.png'
        ],
        [
            'title' => 'Horton Plains National Park',
            'desc' => 'Horton Plains offers a unique experience with cool climate, misty grasslands, and stunning viewpoints like World’s End. Visitors can spot deer, birds, and enjoy scenic nature walks.',
            'image' => 'assets/horton.png'
        ]
    ];

    $stmt = $pdo->prepare("INSERT INTO safari_destinations (title, description, image) VALUES (?, ?, ?)");
    foreach ($safaris as $s) {
        $stmt->execute([$s['title'], $s['desc'], $s['image']]);
    }

    echo "Success: safari_destinations table created and populated.";
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
