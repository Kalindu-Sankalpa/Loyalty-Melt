<?php
// Format points for display
function formatPoints($points) {
    return number_format($points) . ' pts';
}

// Format money for display
function formatMoney($amount) {
    return '$' . number_format($amount, 2);
}

// Format date for display
function formatDate($date) {
    return date('M j, Y', strtotime($date));
}

// Format datetime for display
function formatDateTime($datetime) {
    return date('M j, Y g:i A', strtotime($datetime));
}