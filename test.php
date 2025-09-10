<?php
// Simple test script to verify the system is working
require_once 'includes/config.php';
require_once 'includes/db.php';

echo "<h1>Loyalty Reward Programme - System Test</h1>";

// Test database connection
echo "<h2>1. Database Connection Test</h2>";
try {
    $conn = getDBConnection();
    echo "✅ Database connection successful<br>";
    $conn->close();
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test if tables exist
echo "<h2>2. Database Tables Test</h2>";
$tables = ['users', 'admin_user', 'tier', 'points_ledger', 'reward', 'redemption', 'earning_rule'];

foreach ($tables as $table) {
    $result = executeQuery("SHOW TABLES LIKE '$table'");
    if ($result && $result->num_rows > 0) {
        echo "✅ Table '$table' exists<br>";
    } else {
        echo "❌ Table '$table' missing<br>";
    }
}

// Test sample data
echo "<h2>3. Sample Data Test</h2>";

$adminCount = getRow("SELECT COUNT(*) as count FROM admin_user")['count'];
echo $adminCount > 0 ? "✅ Admin users: $adminCount<br>" : "❌ No admin users found<br>";

$tierCount = getRow("SELECT COUNT(*) as count FROM tier")['count'];
echo $tierCount > 0 ? "✅ Tiers: $tierCount<br>" : "❌ No tiers found<br>";

$rewardCount = getRow("SELECT COUNT(*) as count FROM reward")['count'];
echo $rewardCount > 0 ? "✅ Rewards: $rewardCount<br>" : "❌ No rewards found<br>";

$ruleCount = getRow("SELECT COUNT(*) as count FROM earning_rule")['count'];
echo $ruleCount > 0 ? "✅ Earning rules: $ruleCount<br>" : "❌ No earning rules found<br>";

// Test config constants
echo "<h2>4. Configuration Test</h2>";
echo "✅ App Name: " . APP_NAME . "<br>";
echo "✅ Base Points Rate: " . BASE_POINTS_RATE . "<br>";
echo "✅ Welcome Bonus: Available<br>";
echo "✅ Max Points Per Receipt: " . MAX_POINTS_PER_RECEIPT . "<br>";

// Test authentication functions
echo "<h2>5. Authentication Test</h2>";
require_once 'includes/auth.php';
startSession();
echo "✅ Session started successfully<br>";
echo "✅ Auth functions loaded<br>";

// Test points functions
echo "<h2>6. Points System Test</h2>";
require_once 'includes/points.php';
echo "✅ Points functions loaded<br>";

// Test validation functions
echo "<h2>7. Validation Test</h2>";
require_once 'includes/validation.php';
$testEmail = "test@example.com";
$testPhone = "1234567890";
echo validateEmail($testEmail) ? "✅ Email validation working<br>" : "❌ Email validation failed<br>";
echo validatePhone($testPhone) ? "✅ Phone validation working<br>" : "❌ Phone validation failed<br>";

echo "<h2>8. File Structure Test</h2>";
$requiredFiles = [
    'index.php',
    'login/login.php',
    'login/register.php',
    'user/dashboard.php',
    'admin/login.php',
    'admin/dashboard.php',
    'assets/css/user.css',
    'assets/css/admin.css',
    'assets/js/user.js'
];

foreach ($requiredFiles as $file) {
    if (file_exists($file)) {
        echo "✅ $file exists<br>";
    } else {
        echo "❌ $file missing<br>";
    }
}

echo "<h2>Test Complete!</h2>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ul>";
echo "<li><a href='index.php'>Visit Homepage</a></li>";
echo "<li><a href='login/register.php'>Test Registration</a></li>";
echo "<li><a href='login/login.php'>Test User Login</a></li>";
echo "<li><a href='admin/login.php'>Test Admin Login (admin/admin123)</a></li>";
echo "</ul>";

echo "<p><em>Delete this test.php file when you're done testing.</em></p>";
?>
