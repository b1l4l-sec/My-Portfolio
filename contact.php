<?php
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'includes/functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Invalid request method'], 405);
}

if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
    jsonResponse(['success' => false, 'message' => 'Invalid CSRF token'], 403);
}

$name = sanitize($_POST['name'] ?? '');
$email = sanitize($_POST['email'] ?? '');
$subject = sanitize($_POST['subject'] ?? '');
$message = sanitize($_POST['message'] ?? '');
$foundVia = sanitize($_POST['found_via'] ?? '');

$errors = [];

if (empty($name) || strlen($name) < 2) {
    $errors[] = 'Name must be at least 2 characters';
}

if (empty($email) || !validateEmail($email)) {
    $errors[] = 'Valid email address is required';
}

if (empty($subject) || strlen($subject) < 3) {
    $errors[] = 'Subject must be at least 3 characters';
}

if (empty($message) || strlen($message) < 10) {
    $errors[] = 'Message must be at least 10 characters';
}

if (empty($foundVia)) {
    $errors[] = 'Please select how you found me';
}

if (!empty($errors)) {
    jsonResponse(['success' => false, 'message' => 'Validation failed', 'errors' => $errors], 400);
}

$db = getDB();
$ipAddress = getClientIP();

$sql = "INSERT INTO messages (name, email, subject, message, found_via, ip_address, status, created_at)
        VALUES (?, ?, ?, ?, ?, ?, 'unread', NOW())";

$result = $db->execute($sql, [$name, $email, $subject, $message, $foundVia, $ipAddress]);

if ($result) {
    jsonResponse([
        'success' => true,
        'message' => 'Thank you for your message! I will get back to you soon.'
    ]);
} else {
    jsonResponse([
        'success' => false,
        'message' => 'Failed to send message. Please try again later.'
    ], 500);
}
