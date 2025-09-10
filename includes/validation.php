<?php

function sanitizeInput($input) {
    return trim($input);
}

function validateLogin($data) {
    $errors = [];
    
    if (empty($data['email'])) {
        $errors[] = 'Email is required';
    }
    
    if (empty($data['password'])) {
        $errors[] = 'Password is required';
    }
    
    return $errors;
}

function validateAdminLogin($data) {
    $errors = [];
    
    if (empty($data['username'])) {
        $errors[] = 'Username is required';
    }
    
    if (empty($data['password'])) {
        $errors[] = 'Password is required';
    }
    
    return $errors;
}


// Validate email
function validateEmail($email) {
    return preg_match(EMAIL_PATTERN, $email);
}

// Validate phone
function validatePhone($phone) {
    return preg_match(PHONE_PATTERN, $phone);
}


// validate registration data
function validateRegistration($data) {
    $errors = [];

    if (empty($data['name'])) {
        $errors[] = 'Name is required';
    }

    else if (empty($data['email'])) {
        $errors[] = 'Email is required';
    } elseif (!validateEmail($data['email'])) {
        $errors[] = 'Invalid email format';
    }

    else if (empty($data['phone'])) {
        $errors[] = 'Phone number is required';
    } elseif (!validatePhone($data['phone'])) {
        $errors[] = 'Invalid phone number format';
    }

    else if (empty($data['dob'])) {
        $errors[] = 'Date of birth is required';
    }

    else if (empty($data['password'])) {
        $errors[] = 'Password is required';
    } elseif (strlen($data['password']) < 6) {
        $errors[] = 'Password must be at least 6 characters long';
    }

    else if (empty($data['confirm_password'])) {
        $errors[] = 'Confirm password is required';
    } elseif ($data['password'] !== $data['confirm_password']) {
        $errors[] = 'Passwords do not match';
    }

    return $errors;
}