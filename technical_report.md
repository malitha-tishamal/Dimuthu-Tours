# Dimu Tour & Traveling - Technical Report

Detailed technical documentation of the website's architecture, features, and functionalities.

## 1. Project Overview
Dimu Tour & Traveling is a modern, responsive web application designed for a tourism and taxi service provider in Sri Lanka. It features a robust frontend for customers to explore tours, safaris, and vehicle options, paired with a comprehensive admin dashboard for management.

---

## 2. Technology Stack
- **Backend**: PHP (Procedural with PDO)
- **Database**: MySQL
- **Frontend Framework**: Bootstrap 5.3.0
- **Icons**: FontAwesome 6.4.0, Bootstrap Icons
- **Styling**: Custom CSS (Vanilla) with Modern Design Principles (Glassmorphism, CSS Animations)
- **Client-side Logic**: Vanilla JavaScript (ES6+), Fetch API for AJAX

---

## 3. Core Features & Functionalities

### 🌐 Frontend (Customer Facing)
- **Dynamic Hero Section**: High-impact full-screen slider showing featured tours.
- **Tour Management Display**: Dynamic tour cards with duration badges and detailed info modals.
- **Wildlife Safari Section**: Specialized section for safari experiences with descriptive modals.
- **Dynamic Vehicle Gallery**: 
    - Real-time fetching of taxi vehicles from the database.
    - Interactive cards with "Click to View" functionality.
    - Professional hover effects (opacity-based) and smooth transitions.
    - Vehicle Detail Modals displaying multiple images and specifications.
- **Customer Reviews System**:
    - Interactive review submission form with a custom star-rating dropdown.
    - Dynamic review display showing approved guest feedback.
- **Interactive Tour Map**:
    - Floating animated "Ad-style" banner to catch visitor attention.
    - Semi-transparent full-screen map modal.
    - Click-to-zoom functionality on the map image.
- **Booking & Contact Integration**:
    - AJAX-based booking forms (General & Taxi specifically).
    - Automatic redirection to WhatsApp with pre-filled messages.
    - Direct integration with Google Maps for location.
- **Developer Professional Highlight**: prominent developer credit in footer with a professional bio modal.

### 🛡️ Admin Panel (Management)
- **Secure Authentication**:
    - Modern glassmorphism Login and Signup interfaces.
    - Password visibility toggle and secure password hashing.
    - Manual password reset flow via developer support.
- **Centralized Dashboard**: Oversight of total tours, bookings, and active reviews.
- **Tour Manager**: Full CRUD operations for tour packages (Title, Duration, Description, Image).
- **Review Moderator**:
    - Approval workflow for guest reviews.
    - Ability to edit, delete, or toggle the visibility of any review.
    - Star-rating editor within management modals.
- **Vehicle Fleet Manager**:
    - Dynamic management of the vehicle fleet.
    - Multi-image gallery support for each vehicle.
- **System Settings**: Global management of phone numbers, social media links, and the 'About' text.
- **Technical Support**: Direct contact point for developer assistance integrated into the footer.

---

## 4. Technical Architecture Highlights

### Security
- **SQL Injection Prevention**: Extensive use of PDO prepared statements for all database interactions.
- **XSS Prevention**: Proper escaping of dynamic content using `htmlspecialchars()`.
- **Authentication**: Secure `password_hash()` and `password_verify()` for admin credentials.

### Performance & UX
- **Asynchronous Operations**: All forms (Booking, Reviews) use the Fetch API for seamless submission without page reloads.
- **Optimization**: Images are managed via a central assets folder, with CSS utilized for complex animations to minimize JS overhead.
- **Responsiveness**: Fully fluid design targeting mobile, tablet, and desktop viewports.

---

## 5. Database Schema (Key Tables)
- `settings`: Global site configuration and contact links.
- `tours`: Detailed information on available tour packages.
- `reviews`: Guest messages, ratings, and approval status.
- `vehicles`: Primary vehicle details and pax capacity.
- `vehicle_images`: Gallery mapping for multiple vehicle photos.
- `admins`: Encrypted credentials for system access.
