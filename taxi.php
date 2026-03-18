<?php
require_once 'includes/db.php';
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $vehicle_type = trim($_POST['vehicle_type'] ?? '');
    $date = trim($_POST['date'] ?? '');
    
    if(empty($name) || empty($phone) || empty($vehicle_type) || empty($date)) {
        echo json_encode(['status'=>'error', 'message'=>'Please fill all required fields.']);
        exit;
    }
    
    $stmt = $pdo->prepare("INSERT INTO taxi_bookings (name, phone, vehicle_type, date) VALUES (?, ?, ?, ?)");
    if($stmt->execute([$name, $phone, $vehicle_type, $date])) {
        echo json_encode(['status'=>'success', 'message'=>'Taxi booked successfully! We will contact you soon.']);
    } else {
        echo json_encode(['status'=>'error', 'message'=>'Database error.']);
    }
}
?>
