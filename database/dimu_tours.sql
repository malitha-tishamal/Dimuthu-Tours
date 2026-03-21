-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 21, 2026 at 07:12 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dimu_tours`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`) VALUES
(1, 'admin@dimutours.com', '$2y$10$YXFBhdSJM2uv9vAFmdvHqOIvPE4FyCPYxxabG9YmHtJWtiyoDHyM.'),
(2, 'admin@dimutours.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `tour` varchar(255) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hero_slides`
--

DROP TABLE IF EXISTS `hero_slides`;
CREATE TABLE IF NOT EXISTS `hero_slides` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hero_slides`
--

INSERT INTO `hero_slides` (`id`, `image_path`, `created_at`) VALUES
(16, 'assets/hero/hero_69bbc5136f4ca.jpeg', '2026-03-19 09:42:43'),
(17, 'assets/hero/hero_69bbc51aac5f5.jpeg', '2026-03-19 09:42:50');

-- --------------------------------------------------------

--
-- Table structure for table `memory_images`
--

DROP TABLE IF EXISTS `memory_images`;
CREATE TABLE IF NOT EXISTS `memory_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `memory_id` int DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `memory_id` (`memory_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `memory_images`
--

INSERT INTO `memory_images` (`id`, `memory_id`, `image_path`) VALUES
(1, 1, 'assets/memories/69bbb2ffbb43a_0.jpeg'),
(2, 1, 'assets/memories/69bbb2ffbb919_1.jpeg'),
(3, 1, 'assets/memories/69bbb2ffbbb21_2.jpeg'),
(4, 1, 'assets/memories/69bbb2ffbbd2a_3.jpeg'),
(5, 1, 'assets/memories/69bbb2ffbbece_4.jpeg'),
(6, 2, 'assets/memories/69bbb3533d450_0.jpeg'),
(7, 2, 'assets/memories/69bbb3533db07_1.jpeg'),
(8, 2, 'assets/memories/69bbb3533dd3b_2.jpeg'),
(10, 2, 'assets/memories/69bbb3533e01b_4.jpeg'),
(11, 3, 'assets/memories/69bbb3c776dd5_0.jpeg'),
(12, 3, 'assets/memories/69bbb3c777157_1.jpeg'),
(13, 3, 'assets/memories/69bbb3c7772e4_2.jpeg'),
(14, 3, 'assets/memories/69bbb3c777421_3.jpeg'),
(15, 3, 'assets/memories/69bbb3c77761c_4.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `message` text,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved') DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `country`, `rating`, `message`, `image`, `status`) VALUES
(1, 'Sarah M.', 'UK', 5, 'Amazing experience! Dimu Tours made our trip unforgettable.', NULL, 'approved'),
(2, 'Jason D.', 'Germany', 5, 'Excellent service and great adventures! Highly recommend.', NULL, 'approved'),
(3, 'test', 'India', 5, 'test', NULL, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `safari_destinations`
--

DROP TABLE IF EXISTS `safari_destinations`;
CREATE TABLE IF NOT EXISTS `safari_destinations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','disabled') DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `safari_destinations`
--

INSERT INTO `safari_destinations` (`id`, `title`, `description`, `image`, `status`) VALUES
(1, 'Yala National Park', 'Yala is the most famous national park in Sri Lanka, known for having one of the highest densities of leopards in the world. Visitors can also see elephants, crocodiles, sloth bears, and a wide variety of birds. Perfect for an exciting and adventurous safari experience.', 'assets/yala.png', 'active'),
(2, 'Udawalawe National Park', 'Udawalawe is the best place to see large herds of elephants in their natural habitat. The park offers open landscapes, making wildlife easy to spot. A great destination for families and nature lovers.', 'assets/udawalawe.png', 'active'),
(3, 'Wilpattu National Park', 'Wilpattu is Sri Lanka’s largest national park, famous for its natural lakes (villus) and peaceful environment. It is home to leopards, deer, elephants, and many bird species. Ideal for those who prefer a quiet and less crowded safari.', 'assets/wilpattu.png', 'active'),
(4, 'Minneriya National Park', 'Minneriya is world-famous for “The Gathering,” where hundreds of elephants come together around the reservoir during the dry season. This is one of the greatest wildlife spectacles in Asia.', 'assets/minneriya.png', 'active'),
(5, 'Kaudulla National Park', 'Kaudulla is another excellent place to see elephants and diverse birdlife. It is often combined with Minneriya for a complete safari experience.', 'assets/kaudulla.png', 'active'),
(6, 'Horton Plains National Park', 'Horton Plains offers a unique experience with cool climate, misty grasslands, and stunning viewpoints like World’s End. Visitors can spot deer, birds, and enjoy scenic nature walks.', 'assets/horton.png', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key_name` varchar(100) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_name` (`key_name`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `key_name`, `value`) VALUES
(1, 'hero_title', 'Dimu Tour & Traveling'),
(2, 'hero_subtitle', 'Srilanka Best Travel Partner For Tourists'),
(3, 'phone1', '+94 71 163 5975'),
(4, 'phone2', '+94 78 311 1827'),
(5, 'email', 'info@dimutours.com'),
(6, 'whatsapp', '+94711635975'),
(7, 'about_text', 'We are Dimu Tour & Traveling, your trusted partner for unforgettable experiences in Sri Lanka.'),
(8, 'facebook', 'https://www.facebook.com/dimutours'),
(9, 'instagram', 'https://www.instagram.com/dimutour?igsh=MWZqb2hkZmk5OGpyaQ%3D%3D&utm_source=qr'),
(10, 'tiktok', 'https://www.tiktok.com/@dimu.tour.travels?_r=1&_t=ZS-94pGox2TuaO'),
(11, 'whatsapp_link', 'https://wa.me/message/3HEIK234UGKKA1');

-- --------------------------------------------------------

--
-- Table structure for table `taxi_bookings`
--

DROP TABLE IF EXISTS `taxi_bookings`;
CREATE TABLE IF NOT EXISTS `taxi_bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `vehicle_type` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

DROP TABLE IF EXISTS `tours`;
CREATE TABLE IF NOT EXISTS `tours` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `duration` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','disabled') DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`id`, `title`, `description`, `duration`, `image`, `status`) VALUES
(1, 'Cultural Tours', 'Explore Sigiriya Rock, Ancient Cities, and Temples.', '5 Days / 4 Nights', 'uploads/69baee821995f.png', 'active'),
(2, 'Wildlife Safari', 'Experience Yala and Udawalawe National Parks.', '3 Days / 2 Nights', 'https://images.unsplash.com/photo-1549366021-9f761d450615?q=80&w=600', 'active'),
(3, 'Beach Getaways', 'Relax at the beautiful Southern beaches of Sri Lanka.', '4 Days / 3 Nights', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=600', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tour_days`
--

DROP TABLE IF EXISTS `tour_days`;
CREATE TABLE IF NOT EXISTS `tour_days` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tour_id` int NOT NULL,
  `day_number` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `tour_id` (`tour_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tour_days`
--

INSERT INTO `tour_days` (`id`, `tour_id`, `day_number`, `title`, `description`) VALUES
(1, 3, 1, 'test', 'test'),
(2, 3, 1, 'test', 'test'),
(3, 3, 1, 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `travel_memories`
--

DROP TABLE IF EXISTS `travel_memories`;
CREATE TABLE IF NOT EXISTS `travel_memories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `location` varchar(255) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `status` enum('active','disabled') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `travel_memories`
--

INSERT INTO `travel_memories` (`id`, `title`, `description`, `location`, `event_date`, `status`, `created_at`) VALUES
(1, '2026 Starting Tour', 'test', 'Sigiriya, Sri Lanka', '2026-01-07', 'active', '2026-03-19 08:25:35'),
(2, 'test', 'test', 'test', '2026-03-19', 'active', '2026-03-19 08:26:59');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `pax_count` varchar(50) NOT NULL,
  `icon_class` varchar(100) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `name`, `pax_count`, `icon_class`, `status`) VALUES
(1, 'Cars', 'Max 3 pax', 'fas fa-car', 'active'),
(2, 'Vans', 'Max 8 pax', 'fas fa-shuttle-van', 'active'),
(3, 'Luxury SUV', 'Max 4 pax', 'fas fa-car-side', 'active'),
(4, 'Star Bus', 'Max 25 pax', 'fas fa-bus', 'active'),
(5, 'Full AC Bus', 'Max 50 pax', 'fas fa-bus-alt', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_images`
--

DROP TABLE IF EXISTS `vehicle_images`;
CREATE TABLE IF NOT EXISTS `vehicle_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vehicle_id` int NOT NULL,
  `image_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicle_id` (`vehicle_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
