<?php

// Start session if not already started
function startSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

// Login user
function loginUser($userId, $userData) {
    startSession();
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_name'] = $userData['name'];
    $_SESSION['user_email'] = $userData['email'];
    $_SESSION['user_tier'] = $userData['tier_id'];
    $_SESSION['login_time'] = time();
}

function isUserLoggedIn() {
    startSession();
    return isset($_SESSION['user_id']);
}

function logoutUser(){
    startSession();
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_tier']);
    unset($_SESSION['login_time']);
    session_destroy();
}

// Login admin
function loginAdmin($adminId, $adminData) {
    startSession();
    $_SESSION['admin_id'] = $adminId;
    $_SESSION['admin_username'] = $adminData['username'];
    $_SESSION['admin_role'] = $adminData['role'];
    $_SESSION['admin_login_time'] = time();
}

function isAdminLoggedIn() {
    startSession();
    return isset($_SESSION['admin_id']);
}

// Require admin login
function requireAdminLogin() {
    if (!isAdminLoggedIn()) {
        header('Location: /admin/login.php');
        exit;
    }
}

function logoutAdmin(){
    session_start();
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_username']);
    unset($_SESSION['admin_role']);
    unset($_SESSION['admin_login_time']);
    session_destroy();
}   

// Require user login
function requireUserLogin() {
    if (!isUserLoggedIn()) {
        header('Location: /user/login.php');
        exit;
    }
}
function getCurrentUser(){
    if(!isUserLoggedIn()){
        return null;
    }
    require_once('db.php');
    startSession();
    $userId=isset($_SESSION['user_id'])?$_SESSION['user_id']:null;
    return getRow("SELECT * FROM users WHERE id=?",[$userId]);
    
}

