<?php
$host = 'localhost';
$dbname = 'dimu_tours';
$username = 'root';
$password = ''; // Default WAMP password

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
    $pdo->exec("USE `$dbname`");
    
} catch (PDOException $e) {
    die("Database Connection failed: " . $e->getMessage());
}
?>
