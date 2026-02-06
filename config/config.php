<?php
// Configuration File for Bilal Lbien Portfolio
// InfinityFree Compatible Configuration

// Error Reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Database Configuration
// IMPORTANT: Update these values with your InfinityFree database credentials
define('DB_HOST', 'localhost');      // Localhost for XAMPP
define('DB_NAME', 'if12345678_portfolio');
define('DB_USER', 'root');           // XAMPP default user is 'root'
define('DB_PASS', '');               // XAMPP default password is empty
define('DB_CHARSET', 'utf8mb4');

// Base URL Configuration
define('BASE_URL', 'http://localhost/portfolio/');

// Site Configuration
define('SITE_NAME', 'Bilal Lbien - Portfolio');
define('SITE_URL', 'http://localhost/portfolio');
define('ADMIN_EMAIL', 'contact@bilallbien.com');

// Security Configuration
define('SESSION_LIFETIME', 7200);
define('CSRF_TOKEN_NAME', 'csrf_token');
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_TIMEOUT', 900);

// File Upload Configuration
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('MAX_FILE_SIZE', 5242880);
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'pdf', 'webp']);

// Timezone
date_default_timezone_set('UTC');

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Auto-generate CSRF token
if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
    $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
}
