<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
require_once '../includes/db.php';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Dimu Tours</title>
    <link rel="icon" type="image/jpeg" href="../assets/logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar { min-height: 100vh; background: #343a40; }
        .sidebar a { color: rgba(255,255,255,0.8); text-decoration: none; padding: 12px 20px; display: block; }
        .sidebar a:hover, .sidebar a.active { background: #495057; color: #fff; }
        .main-content { background: #f8f9fa; min-height: 100vh; }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar text-white shadow" style="width: 250px; flex-shrink: 0;">
        <div class="p-4 text-center border-bottom border-secondary">
            <h5 class="mb-0 fw-bold text-white">Dimu Admin</h5>
        </div>
        <div class="py-3">
            <a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>"><i class="fas fa-home ms-2 me-3"></i>Dashboard</a>
            <a href="tours.php" class="<?php echo $current_page == 'tours.php' ? 'active' : ''; ?>"><i class="fas fa-map ms-2 me-3"></i>Manage Tours</a>
            <a href="bookings.php" class="<?php echo $current_page == 'bookings.php' ? 'active' : ''; ?>"><i class="fas fa-calendar-check ms-2 me-3"></i>Tour Bookings</a>
            <a href="taxi_bookings.php" class="<?php echo $current_page == 'taxi_bookings.php' ? 'active' : ''; ?>"><i class="fas fa-taxi ms-2 me-3"></i>Taxi Bookings</a>
            <a href="reviews.php" class="<?php echo $current_page == 'reviews.php' ? 'active' : ''; ?>"><i class="fas fa-star ms-2 me-3"></i>Guest Reviews</a>
            <a href="settings.php" class="<?php echo $current_page == 'settings.php' ? 'active' : ''; ?>"><i class="fas fa-cog ms-2 me-3"></i>Site Settings</a>
        </div>
        <div class="mt-auto border-top border-secondary position-absolute bottom-0 w-100" style="max-width: 250px;">
            <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt ms-2 me-3"></i>Logout</a>
            <a href="../index.php" target="_blank" class="text-info"><i class="fas fa-external-link-alt ms-2 me-3"></i>View Site</a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content w-100 p-4">
