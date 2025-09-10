<?php
header('Content-Type: application/json');
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/validation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}
$member_id = $_POST['id'];
$name = sanitizeInput($_POST['name']);
$email = sanitizeInput($_POST['email']);
$phone = sanitizeInput($_POST['phone']);
$tier = sanitizeInput($_POST['tier_id']);
$points = $_POST['points_adjustment'];

// Insert new user
$inserted = insertRow(
    "UPDATE users SET `name` = ?, email=?, phone=?, tier_id=?, points_balance=? WHERE id = ?",[$name, $email, $phone, $tier, $points, $member_id]
);

if ($inserted) {
    echo json_encode(['success' => true, 'message' => 'Registration successful']);
    exit;
} else {
    echo json_encode(['success' => false, 'message' => ERROR_INTERNAL]);
}