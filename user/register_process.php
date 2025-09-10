<?php
header('Content-Type: application/json');
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/validation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$name = sanitizeInput($_POST['name']);
$email = sanitizeInput($_POST['email']);
$phone = sanitizeInput($_POST['phone']);
$dob = isset($_POST['dob']) ? sanitizeInput($_POST['dob']) : null;
$password = sanitizeInput($_POST['password']);
$confirm_password = sanitizeInput($_POST['confirm_password']);
$dob = isset($_POST['dob']) ? sanitizeInput($_POST['dob']) : null;
$marketing_opt_in = isset($_POST['marketing_opt_in']) ? 1 : 0;

$errors = validateRegistration([
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'dob' => $dob,
    'password' => $password,
    'confirm_password' => $confirm_password
]);

if (!empty($errors)) {
    $errorMsg = implode(', ', $errors);
    echo json_encode(['success' => false, 'message' => $errorMsg]);
    exit;
}

// Check for existing email or phone
$existingUser = getRow("SELECT id FROM users WHERE email = ? OR phone = ?", [$email, $phone]);
if ($existingUser) {
    echo json_encode(['success' => false, 'message' => ERROR_USER_EXISTS]);
    exit;
}

// Insert new user
$inserted = insertRow(
    "INSERT INTO users (name, email, phone, dob, password, marketing_opt_in, joined_at) VALUES (?, ?, ?, ?, ?, ?, NOW())",
    [$name, $email, $phone, $dob, $password, $marketing_opt_in]
);
if ($inserted) {
    // Auto-login after registration
    $newUser = getRow("SELECT * FROM users WHERE email = ?", [$email]);
    loginUser($newUser['id'], $newUser);
    echo json_encode(['success' => true, 'message' => 'Registration successful']);
    exit;
} else {
    echo json_encode(['success' => false, 'message' => ERROR_INTERNAL]);
    exit;
}