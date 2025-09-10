<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.php';

$id = $_GET['member_id'];

$inserted = insertRow(
    "DELETE FROM users WHERE id = ?",[$id]
);

if ($inserted) {
    header('location: members.php');
    exit;
} else {
    echo "delete fail";
}