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
- **Travel Memories (Blogging/Gallery)**:
    - Dedicated section for past trip stories and highlights.
    - Multi-image carousel for each memory event.
    - Location tagging and chronological event dating.
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
- **Tour Manager & Itinerary**: 
    - Full CRUD operations for tour packages.
    - Integrated day-by-day itinerary builder for detailed tour schedules.
- **Review Moderator**:
    - Approval workflow for guest reviews.
    - Ability to edit, delete, or toggle the visibility of any review.
    - Star-rating editor within management modals.
- **Vehicle Fleet Manager**:
    - Dynamic management of the vehicle fleet.
    - Multi-image gallery support for each vehicle.
- **Travel Memories Manager**: Full control over travel story gallery and multiple image uploads.
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
- `site_settings`: Global site configuration (Contact info, Hero text, Social links).
- `tours`: Primary tour package information.
- `tour_days`: One-to-Many relationship with `tours` for day-wise itineraries.
- `reviews`: Guest messages, ratings, and approval status.
- `vehicles`: Fleet details and passenger capacity.
- `vehicle_images`: Multi-image storage for vehicles.
- `travel_memories`: Event-based trip stories.
- `memory_images`: Multi-image storage for travel memories.
- `bookings` / `taxi_bookings`: Leads captured from the frontend.
- `admins`: Encrypted credentials for system access.

---

## 6. Project Directory Structure
```text
/Dimu Tours
│
├── /admin                  # Management dashboard logic
│   ├── /includes           # Admin shared components
│   ├── dashboard.php       # Main overview
│   └── tours.php, etc.     # Entity management files
│
├── /assets                 # Static files (Images, CSS, JS)
├── /database               # Database exports and initialization
├── /includes               # Frontend shared components (Header/Footer)
├── /uploads                # Dynamic user/admin uploads
├── index.php               # Customer-facing landing page
└── technical_report.md     # Project documentation
```

---

## 7. UI/UX & Design Philosophy
- **Glassmorphism**: Applied to modals and admin cards for a modern, airy feel.
- **Animation Strategy**: Uses `Animate.css` for entry transitions and custom CSS keyframes for hover states.
- **Visual Hierarchy**: Large typography for hero sections with high-contrast call-to-action buttons.
- **Accessibility**: ARIA labels on interactive elements and semi-transparent overlays for text readability over images.

---

## 8. Development Standards
- **Coding Style**: Procedural PHP with a focus on modularity via `include` files.
- **Data Integrity**: Consistent use of foreign keys (where supported) and transactional logic for multi-image uploads.
- **Error Handling**: Graceful degradation with fallback images for missing tour/vehicle photos.

---

## 9. System Requirements
- **Server**: Apache/Nginx (WAMP/XAMPP recommended for local development)
- **PHP Version**: 7.4 or higher (supports PDO and Fetch API)
- **Database**: MySQL 5.7+ or MariaDB 10.3+
- **Browser Compatibility**: Modern browsers (Chrome, Firefox, Safari, Edge) supporting ES6 and CSS Grid/Flexbox.

---

## 10. Installation & Setup
1. **Clone/Download**: Extract the project files into your server root (e.g., `www/dimu-tours`).
2. **Database Config**: Update `includes/db.php` with your local database credentials.
3. **Initialization**:
    - Import `schema.sql` via phpMyAdmin or run `setup_db.php` in your browser.
    - This will create the necessary tables and seed initial data.
4. **Admin Access**: Navigate to `/admin` to log in or sign up.
5. **Assets**: Ensure the `uploads/` folder has write permissions for image management.

---

## 11. Developer Contact
For further technical assistance or system customizations, contact:
- **Developer**: Malitha Tishamal
- **Portfolio**: [malithatishamal.42web.io](http://malithatishamal.42web.io)
- **Email**: [malithatishamal@gmail.com](mailto:malithatishamal@gmail.com)
- **WhatsApp**: [+94 78 553 0992](https://wa.me/94785530992)

