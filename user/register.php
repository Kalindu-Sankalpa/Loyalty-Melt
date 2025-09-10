<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
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
            <span class="title"><?php echo APP_NAME ?> - Register</span>
            <form id="register-form">
                <label for="name">
                    <span>👤</span>
                    <input name="name" type="text" id="name" placeholder="Full Name">
                </label>
                <label for="email">
                    <span>📧</span>
                    <input name="email" type="email" id="email" placeholder="Email">
                </label>
                <label for="phone">
                    <span>📞</span>
                    <input name="phone" type="tel" id="phone" placeholder="1234567890">
                </label>
                <label for="dob">
                    <span>📅</span>
                    <input name="dob" type="date" id="dob">
                </label>
                <label for="password">
                    <span>🔒</span>
                    <input name="password" type="password" id="password" placeholder="Password">
                </label>
                <label for="confirm_password">
                    <span>🔒</span>
                    <input name="confirm_password" type="password" id="confirm_password" placeholder="Confirm Password">
                </label>
                <div class="checkbox-label">
                    <input name="marketing_opt_in" type="checkbox" id="marketing_opt_in" value="1">
                    <span>I want to receive promotional emails and offers</span>
                </div>
                <button class="btn-outline" type="submit">Create Account</button>
                <span class="error-message"></span>
            </form>
        </div>
    </div>
    <script src="/assets/js/user_register.js"></script>
</body>

</html>