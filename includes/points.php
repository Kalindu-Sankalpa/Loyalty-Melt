<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.php';

function getUserLedger($id, $limit = 20, $offset = 0)
{
    $sql = "SELECT * FROM points_ledger WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ? ";
    return getRows($sql, [$id, $limit, $offset]);
}

function getUserRedemptions($id, $limit = 20)
{
    $sql = "SELECT r.*, rw.name as reward_name 
            FROM redemption r 
            JOIN reward rw ON r.reward_id = rw.id 
            WHERE r.user_id = ? 
            ORDER BY r.issued_at DESC 
            LIMIT ? ";
    return getRows($sql, [$id, $limit]);
}

// Get tier name by ID
function getTierName($tierId) {
    require_once 'db.php';
    $tier = getRow("SELECT name FROM tier WHERE id = ?", [$tierId]);
    return $tier ? $tier['name'] : 'Unknown';
}

// Get status badge HTML
function getStatusBadge($status) {
    $class = strtolower($status);
    $text = ucfirst($status);
    return "<span class='status-badge status-{$class}'>{$text}</span>";
}

// Get tier badge HTML
function getTierBadge($tierId) {
    $tierName = getTierName($tierId);
    $class = strtolower(str_replace(' ', '-', $tierName));
    return "<span class='tier-badge tier-{$class}'>{$tierName}</span>";
}