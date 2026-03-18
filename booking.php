<?php
require_once 'includes/db.php';
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $whatsapp = trim($_POST['whatsapp'] ?? '');
    $tour = trim($_POST['tour'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // basic validation
    if(empty($name) || empty($email) || empty($tour)) {
        echo json_encode(['status'=>'error', 'message'=>'Please fill all required fields.']);
        exit;
    }
    
    $stmt = $pdo->prepare("INSERT INTO bookings (name, country, email, whatsapp, tour, message) VALUES (?, ?, ?, ?, ?, ?)");
    if($stmt->execute([$name, $country, $email, $whatsapp, $tour, $message])) {
        // Fetch WA from settings
        $w_stmt = $pdo->query("SELECT value FROM site_settings WHERE key_name='whatsapp'");
        $w_num = $w_stmt->fetchColumn();
        $w_num = str_replace(['+', ' '], '', $w_num);
        
        $wa_msg = urlencode("Hello! I just booked a tour on your website.\nName: $name\nCountry: $country\nTour: $tour");
        $wa_link = "https://wa.me/{$w_num}?text={$wa_msg}";
        
        echo json_encode(['status'=>'success', 'whatsapp_url'=>$wa_link]);
    } else {
        echo json_encode(['status'=>'error', 'message'=>'Database error.']);
    }
}
?>
