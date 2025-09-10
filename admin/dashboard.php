<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/format.php';
requireAdminLogin();


// Get basic stats
$totalMembers = getRow("SELECT COUNT(*) as count FROM users")['count'];
$totalPointsIssued = getRow("SELECT SUM(delta) as total FROM points_ledger WHERE delta > 0")['total'] ?? 0;
$totalRedemptions = getRow("SELECT COUNT(*) as count FROM redemption")['count'];
$thisMonthMembers = getRow("SELECT COUNT(*) as count FROM users WHERE MONTH(joined_at) = MONTH(NOW()) AND YEAR(joined_at) = YEAR(NOW())")['count'];


// Recent activity
$recentMembers = getRows("SELECT name, email, joined_at FROM users ORDER BY joined_at DESC LIMIT 5");
$recentRedemptions = getRows("
    SELECT u.name, r.name as reward_name, rd.issued_at 
    FROM redemption rd 
    JOIN users u ON rd.user_id = u.id 
    JOIN reward r ON rd.reward_id = r.id 
    ORDER BY rd.issued_at DESC 
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="shortcut icon" href="/assets/img/icon.png" type="image/x-icon">
    <title><?php echo APP_NAME ?> - Admin Dashboard</title>
</head>

<body>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/admin_nav.php'; ?>

    <div class="container">
        <h1>Admin Dashboard</h1>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-info">
                    <h3>Total Members</h3>
                    <div class="stat-value"><?php echo number_format($totalMembers); ?></div>
                    <div class="stat-change">+<?php echo $thisMonthMembers; ?> this month</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🎯</div>
                <div class="stat-info">
                    <h3>Points Issued</h3>
                    <div class="stat-value"><?php echo formatPoints($totalPointsIssued); ?></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🎁</div>
                <div class="stat-info">
                    <h3>Total Redemptions</h3>
                    <div class="stat-value"><?php echo number_format($totalRedemptions); ?></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">💰</div>
                <div class="stat-info">
                    <h3>Points Liability</h3>
                    <?php
                    $liability = getRow("SELECT SUM(points_balance) as total FROM users")['total'] ?? 0;
                    ?>
                    <div class="stat-value"><?php echo formatPoints($liability); ?></div>
                </div>
            </div>
        </div>

        <div class="table-grid">
            <div class="table-card">
                <h3>Recent Members</h3>
                <?php if (!empty($recentMembers)): ?>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentMembers as $member): ?>
                                    <tr>
                                        <td><?php echo $member['name']; ?></td>
                                        <td><?php echo $member['email']; ?></td>
                                        <td><?php echo formatDate($member['joined_at']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="no-data">No members yet.</p>
                <?php endif; ?>
                <a href="members.php" class="view-all-link">View All Members</a>
            </div>

            <div class="table-card">
                <h3>Recent Redemptions</h3>
                <?php if (!empty($recentRedemptions)): ?>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Reward</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentRedemptions as $redemption): ?>
                                    <tr>
                                        <td><?php echo $redemption['name']; ?></td>
                                        <td><?php echo $redemption['reward_name']; ?></td>
                                        <td><?php echo formatDate($redemption['issued_at']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="no-data">No redemptions yet.</p>
                <?php endif; ?>
                <a href="#" class="view-all-link">View Reports</a>
            </div>
        </div>
    </div>

    <script src="/assets/js/script.js"></script>
</body>

</html>