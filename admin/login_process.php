<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/validation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}


$username = sanitizeInput($_POST['username']);
$password = sanitizeInput($_POST['password']);

$errors = validateAdminLogin(['username' => $username, 'password' => $password]);


if (!empty($errors)) {
    $errorMsg = implode(', ', $errors);
    echo json_encode(['success' => false, 'message' => $errorMsg]);
    exit;
}

// Check Admin credentials
$admin = getRow("SELECT * FROM admin_user WHERE username = ?", [$username]);

if ($admin && $password === $admin['password']) {
    // Login successful
    loginAdmin($admin['id'], $admin);
    echo json_encode(['success' => true, 'message' => 'Login successful']);
    exit;
} else {
    // Login failed
    echo json_encode(['success' => false, 'message' => ERROR_INVALID_LOGIN]);
    exit;
}
