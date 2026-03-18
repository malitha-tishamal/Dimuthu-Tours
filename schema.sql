CREATE DATABASE IF NOT EXISTS dimu_tours;
USE dimu_tours;

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS tours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    duration VARCHAR(50),
    image VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    country VARCHAR(100),
    rating INT,
    message TEXT,
    image VARCHAR(255),
    status ENUM('pending','approved') DEFAULT 'pending'
);

CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    country VARCHAR(100),
    email VARCHAR(255),
    whatsapp VARCHAR(20),
    tour VARCHAR(255),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS taxi_bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    vehicle_type VARCHAR(50),
    date DATE
);

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    key_name VARCHAR(100) UNIQUE,
    value TEXT
);

-- Insert default admin: admin@dimutours.com / password123
INSERT INTO admins (email, password) VALUES ('admin@dimutours.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm') ON DUPLICATE KEY UPDATE email=email;

-- Insert default settings
INSERT IGNORE INTO site_settings (key_name, value) VALUES
('hero_title', 'Explore the Wonders of Sri Lanka'),
('hero_subtitle', 'Your Adventure Starts Here!'),
('phone1', '+94 71 163 5975'),
('phone2', '+94 78 311 1827'),
('email', 'info@dimutours.com'),
('whatsapp', '+94711635975'),
('about_text', 'We are Dimu Tour & Traveling, your trusted partner for unforgettable experiences in Sri Lanka.');
