<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth.php';
session_start();
// check whether user already logged in
if (isUserLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/login.css">
    <link rel="shortcut icon" href="/assets/img/icon.png" type="image/x-icon">
    <title><?php echo APP_NAME ?></title>
</head>

<body>
    <div class="card">
        <div class="logo">
            <img src="/assets/img/icon.png" alt="Loyalty Link Logo">
            <img src="/assets/img/logo.png" alt="Loyalty Link Logo">
        </div>
        <div class="form">
            <span class="title"><?php echo APP_NAME ?> - Login</span>
            <form id="login-form">
                <label for="user">
                    <span>👤</span>
                    <input name="email" type="email" id="user" placeholder="Email">
                </label>
                <label for="password">
                    <span>🔒</span>
                    <input name="password" type="password" id="pass" placeholder="Password">
                </label>
                <button class="btn-outline" type="submit">Login</button>
                <span class="error-message"></span>
            </form>
        </div>
    </div>
    <script src="/assets/js/user_login.js"></script>
</body>

</html>