<?php
// App configurations
define('APP_NAME', 'Loyalty Melt');
define('APP_VERSION', '1.0.0');

// Database configurations
define('DB_HOST', 'localhost');
define('DB_USER', 'loyalty_user');
define('DB_PASS', 'loyalty@1234');
define('DB_NAME', 'loyalty_db');

// Error messages
define('ERROR_INVALID_LOGIN', 'Invalid Credentials');
define('ERROR_USER_EXISTS', 'User with this email or phone number already exists');
define('ERROR_INVALID_DATA', 'Invalid data provided');
define('ERROR_UNAUTHORIZED', 'You must be logged in to access this page');
define('ERROR_FORBIDDEN', 'You do not have permission to access this page');
define('ERROR_NOT_FOUND', 'Requested resource not found');
define('ERROR_INTERNAL', 'An internal error occurred. Please try again later');

// Error messages
define('ERROR_INVALID_EMAIL', 'Please enter a valid email address');
define('ERROR_INVALID_PHONE', 'Please enter a valid phone number (10-15 digits)');
define('ERROR_PASSWORD_TOO_SHORT', 'Password must be at least 6 characters long');
define('ERROR_PASSWORDS_DONT_MATCH', 'Passwords do not match');
define('ERROR_EMAIL_EXISTS', 'Email already exists');
define('ERROR_PHONE_EXISTS', 'Phone number already exists');
define('ERROR_INSUFFICIENT_POINTS', 'Insufficient points for this reward');
define('ERROR_REWARD_NOT_AVAILABLE', 'This reward is not available');
define('ERROR_MAX_REDEMPTIONS_REACHED', 'Maximum redemptions per day reached');


// Points and rewards settings
define('BASE_POINTS_RATE', 1); // 1 point per $1
define('MAX_POINTS_PER_RECEIPT', 1000);
define('MAX_REDEMPTIONS_PER_DAY', 2);
define('REDEMPTION_CODE_LENGTH', 8);
define('REDEMPTION_EXPIRY_DAYS', 14);
define('POINTS_EXPIRY_MONTHS', 12);

// Validation patterns
define('EMAIL_PATTERN', '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/');
define('PHONE_PATTERN', '/^[0-9]{10,15}$/');
define('PASSWORD_MIN_LENGTH', 6);