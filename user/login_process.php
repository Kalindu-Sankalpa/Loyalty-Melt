<?php
header('Content-Type: application/json');
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/validation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}


$email = sanitizeInput($_POST['email']);
$password = sanitizeInput($_POST['password']);

$errors = validateLogin(['email' => $email, 'password' => $password]);


if (!empty($errors)) {
    $errorMsg = implode(', ', $errors);
    echo json_encode(['success' => false, 'message' => $errorMsg]);
    exit;
}

// Check user credentials
$user = getRow("SELECT * FROM users WHERE email = ?", [$email]);


if ($user && $password === $user['password']) {
    // Login successful
    loginUser($user['id'], $user);
    echo json_encode(['success' => true, 'message' => 'Login successful']);
    exit;
} else {
    // Login failed
    echo json_encode(['success' => false, 'message' => ERROR_INVALID_LOGIN]);
    exit;
}
