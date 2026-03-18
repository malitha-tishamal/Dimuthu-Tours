<?php
require_once 'includes/db.php';
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $rating = (int)($_POST['rating'] ?? 5);
    $message = trim($_POST['message'] ?? '');
    
    if(empty($name) || empty($message)) {
        echo json_encode(['status'=>'error', 'message'=>'Please fill all required fields.']);
        exit;
    }
    
    $stmt = $pdo->prepare("INSERT INTO reviews (name, country, rating, message, status) VALUES (?, ?, ?, ?, 'pending')");
    if($stmt->execute([$name, $country, $rating, $message])) {
        echo json_encode(['status'=>'success']);
    } else {
        echo json_encode(['status'=>'error', 'message'=>'Database error.']);
    }
}
?>
