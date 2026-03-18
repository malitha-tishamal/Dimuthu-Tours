<?php
require_once __DIR__ . '/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dimu Tour & Traveling | Sri Lanka</title>
    <link rel="icon" type="image/jpeg" href="assets/logo.jpg">
    <meta name="description" content="Explore the wonders of Sri Lanka with Dimu Tour & Traveling. Private tours, wildlife safaris, beach getaways, and more.">
    <meta name="keywords" content="Sri Lanka Tours, Sri Lanka Travel Packages, Private Tours Sri Lanka, Wildlife Safari Sri Lanka">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="index.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm py-3">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="index.php">
            <img src="assets/logo.jpg" alt="Dimu Tour Travels" style="max-height: 65px; object-fit: contain;">
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-medium">
                <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#tours">Sri Lanka Tours</a></li>
                <li class="nav-item"><a class="nav-link" href="#reviews">Guest Reviews</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-primary px-4 rounded-pill fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#bookingModal">Book Now</button>
            </div>
        </div>
    </div>
</nav>

<!-- Main content starts here -->
