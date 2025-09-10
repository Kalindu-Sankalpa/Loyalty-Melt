<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/format.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/points.php';

requireUserLogin();

$user = getCurrentUser();

if (!$user) {
    logoutUser();
    header('location:/user/login.php');
    exit;
}

$recentLedger = getUserLedger($user['id'], 5);
$recentRedemptions = getUserRedemptions($user['id'], 3);
$tier = getRow("SELECT * FROM tier WHERE id = ?", [$user['id']]);
$nextTier = getRow("SELECT * FROM tier WHERE min_annual_points > ? ORDER BY min_annual_points ASC LIMIT 1", [$user['annual_points']]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="/assets/css/user.css">
    <link rel="shortcut icon" href="/assets/img/icon.png" type="image/x-icon">
</head>

<body>
    <nav class="nav-bar">
        <div class="nav-toggle">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>

        <div class="greeting">
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
        </div>
        <div class="logo">
            <img src="/assets/img/icon.png" alt="">
            <img src="/assets/img/logo.png" alt="">
        </div>


        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="#">Activity</a>
            <a href="#">Rewards</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container">


        <div class="dashboard-header">
            <h1>Welcome back, <?php echo $user['name']; ?>!</h1>
            <div class="tier-badge">
                <?php echo getTierBadge($user['tier_id']); ?>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card points-balance">
                <div class="stat-icon">🎯</div>
                <div class="stat-info">
                    <h3>Points Balance</h3>
                    <div class="stat-value"><?php echo formatPoints($user['points_balance']); ?></div>
                </div>
            </div>

            <div class="stat-card annual-points">
                <div class="stat-icon">📅</div>
                <div class="stat-info">
                    <h3>This Year</h3>
                    <div class="stat-value"><?php echo formatPoints($user['annual_points']); ?></div>
                </div>
            </div>

            <div class="stat-card tier-progress">
                <div class="stat-icon">🏆</div>
                <div class="stat-info">
                    <h3>Current Tier</h3>
                    <div class="stat-value"><?php echo $tier['name']; ?></div>
                    <?php if ($nextTier): ?>
                        <div class="progress-info">
                            <?php
                            $needed = $nextTier['min_annual_points'] - $user['annual_points'];
                            echo $needed > 0 ? "{$needed} points to {$nextTier['name']}" : "Highest tier reached!";
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="stat-card member-since">
                <div class="stat-icon">📍</div>
                <div class="stat-info">
                    <h3>Member Since</h3>
                    <div class="stat-value"><?php echo formatDate($user['joined_at']); ?></div>
                </div>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="card recent-activity">
                <h3>Recent Activity</h3>
                <?php if (!empty($recentLedger)): ?>
                    <div class="activity-list">
                        <?php foreach ($recentLedger as $entry): ?>
                            <div class="activity-item">
                                <div class="activity-info">
                                    <div class="activity-reason"><?php echo $entry['reason']; ?></div>
                                    <div class="activity-date"><?php echo formatDateTime($entry['created_at']); ?></div>
                                </div>
                                <div class="activity-points <?php echo $entry['delta'] > 0 ? 'positive' : 'negative'; ?>">
                                    <?php echo ($entry['delta'] > 0 ? '+' : '') . formatPoints($entry['delta']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="no-data">No activity yet. Start earning points with your first purchase!</p>
                <?php endif; ?>
                <a href="ledger.php" class="view-all-link">View All Activity</a>
            </div>

            <div class="card recent-redemptions">
                <h3>Recent Redemptions</h3>
                <?php if (!empty($recentRedemptions)): ?>
                    <div class="redemption-list">
                        <?php foreach ($recentRedemptions as $redemption): ?>
                            <div class="redemption-item">
                                <div class="redemption-info">
                                    <div class="redemption-name"><?php echo $redemption['reward_name']; ?></div>
                                    <div class="redemption-code">Code: <?php echo $redemption['code']; ?></div>
                                    <div class="redemption-status"><?php echo getStatusBadge($redemption['status']); ?></div>
                                </div>
                                <div class="redemption-cost">
                                    <?php echo formatPoints($redemption['points_cost']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="no-data">No redemptions yet. Browse our rewards to start redeeming!</p>
                <?php endif; ?>
                <a href="rewards.php" class="view-all-link">Browse Rewards</a>
            </div>
        </div>

    </div>
    <script src="/assets/js/script.js"></script>
</body>

</html>