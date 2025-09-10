<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/format.php';

// Check if admin is logged in
requireAdminLogin();

$member_id = intval($_GET['id'] ?? 0);
if (!$member_id) {
    header('Location: members.php');
    exit;
}

// Get member details
$member = getRow("
    SELECT u.*, t.name as tier_name, t.color as tier_color, t.points_required, t.multiplier
    FROM users u 
    LEFT JOIN tier t ON u.tier_id = t.id 
    WHERE u.id = ?
", [$member_id]);

if (!$member) {
    header('Location: members.php');
    exit;
}

// Get points history
$pointsHistory = getRows("
    SELECT * FROM points_ledger 
    WHERE user_id = ? 
    ORDER BY created_at DESC 
    LIMIT 50
", [$member_id]);

// Get redemption history
$redemptions = getRows("
    SELECT rd.*, r.name as reward_name, r.points_cost
    FROM redemption rd
    JOIN reward r ON rd.reward_id = r.id
    WHERE rd.user_id = ?
    ORDER BY rd.issued_at DESC
    LIMIT 20
", [$member_id]);

// Calculate statistics
$stats = getRow("
    SELECT 
        COALESCE(SUM(CASE WHEN delta > 0 THEN delta ELSE 0 END), 0) as total_earned,
        COALESCE(SUM(CASE WHEN delta < 0 THEN ABS(delta) ELSE 0 END), 0) as total_redeemed,
        COUNT(CASE WHEN delta > 0 THEN 1 END) as earning_transactions,
        COUNT(CASE WHEN delta < 0 THEN 1 END) as redemption_transactions
    FROM points_ledger
    WHERE user_id = ?
", [$member_id]);

// Get next tier information
$nextTier = getRow("
    SELECT * FROM tier 
    WHERE points_required > ? 
    ORDER BY points_required ASC 
    LIMIT 1
", [$member['points_balance']]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="/assets/css/member.css">
    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">
    <title><?php echo htmlspecialchars($member['name']); ?> - Member Details</title>
</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/admin_nav.php'; ?>
    
    <main class="admin-main">
        <div class="page-header">
            <h1>Member Details</h1>
            <div class="header-actions">
                <a href="member_edit.php?id=<?php echo $member['id']; ?>" class="btn btn-primary">Edit Member</a>
                <a href="earn_points.php?member_id=<?php echo $member['id']; ?>" class="btn btn-secondary">Award Points</a>
                <a href="members.php" class="btn btn-outline">Back to Members</a>
            </div>
        </div>

        <div class="member-profile">
            <!-- Member Info Card -->
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <?php echo strtoupper(substr($member['name'], 0, 2)); ?>
                    </div>
                    <div class="profile-info">
                        <h2><?php echo htmlspecialchars($member['name']); ?></h2>
                        <p class="profile-email"><?php echo htmlspecialchars($member['email']); ?></p>
                        <?php if ($member['phone']): ?>
                            <p class="profile-phone"><?php echo htmlspecialchars($member['phone']); ?></p>
                        <?php endif; ?>
                        <p class="profile-joined">Member since <?php echo formatDate($member['joined_at']); ?></p>
                    </div>
                </div>

                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-label">Current Points</div>
                        <div class="stat-value points"><?php echo formatPoints($member['points_balance']); ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Current Tier</div>
                        <div class="stat-value">
                            <?php if ($member['tier_name']): ?>
                                <span class="tier-badge" style="background-color: <?php echo $member['tier_color']; ?>">
                                    <?php echo htmlspecialchars($member['tier_name']); ?>
                                </span>
                            <?php else: ?>
                                <span class="tier-badge">No Tier</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Lifetime Earned</div>
                        <div class="stat-value"><?php echo formatPoints($stats['total_earned']); ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Total Redeemed</div>
                        <div class="stat-value"><?php echo formatPoints($stats['total_redeemed']); ?></div>
                    </div>
                </div>

                <?php if ($nextTier): ?>
                    <div class="tier-progress">
                        <div class="progress-header">
                            <span>Progress to <?php echo htmlspecialchars($nextTier['name']); ?></span>
                            <span><?php echo formatPoints($member['points_balance']); ?> / <?php echo formatPoints($nextTier['points_required']); ?></span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php 
                                echo min(100, ($member['points_balance'] / $nextTier['points_required']) * 100); 
                            ?>%"></div>
                        </div>
                        <div class="progress-note">
                            <?php 
                            $pointsNeeded = $nextTier['points_required'] - $member['points_balance'];
                            if ($pointsNeeded > 0): 
                            ?>
                                <?php echo formatPoints($pointsNeeded); ?> points needed
                            <?php else: ?>
                                Ready for tier upgrade!
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="member-activity">
            <!-- Points History -->
            <div class="activity-card">
                <h3>Points History</h3>
                <?php if (!empty($pointsHistory)): ?>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Points</th>
                                    <th>Description</th>
                                    <th>Balance After</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pointsHistory as $entry): ?>
                                    <tr>
                                        <td><?php echo formatDateTime($entry['created_at']); ?></td>
                                        <td>
                                            <span class="transaction-type <?php echo $entry['delta'] > 0 ? 'earned' : 'redeemed'; ?>">
                                                <?php echo $entry['delta'] > 0 ? 'Earned' : 'Redeemed'; ?>
                                            </span>
                                        </td>
                                        <td class="points-cell <?php echo $entry['delta'] > 0 ? 'positive' : 'negative'; ?>">
                                            <?php echo $entry['delta'] > 0 ? '+' : ''; ?><?php echo formatPoints($entry['delta']); ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($entry['description'] ?? 'N/A'); ?></td>
                                        <td class="points-cell"><?php echo formatPoints($entry['balance_after']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if (count($pointsHistory) >= 50): ?>
                        <div class="table-note">
                            Showing last 50 transactions. <a href="member_full_history.php?id=<?php echo $member['id']; ?>">View full history</a>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="no-data">
                        <p>No points activity yet.</p>
                        <a href="earn_points.php?member_id=<?php echo $member['id']; ?>" class="btn btn-primary">Award First Points</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Redemption History -->
            <div class="activity-card">
                <h3>Redemption History</h3>
                <?php if (!empty($redemptions)): ?>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Reward</th>
                                    <th>Points Cost</th>
                                    <th>Code</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($redemptions as $redemption): ?>
                                    <tr>
                                        <td><?php echo formatDateTime($redemption['issued_at']); ?></td>
                                        <td><strong><?php echo htmlspecialchars($redemption['reward_name']); ?></strong></td>
                                        <td class="points-cell"><?php echo formatPoints($redemption['points_cost']); ?></td>
                                        <td class="code-cell">
                                            <code><?php echo htmlspecialchars($redemption['code']); ?></code>
                                        </td>
                                        <td>
                                            <span class="status-badge <?php echo $redemption['is_used'] ? 'used' : 'active'; ?>">
                                                <?php echo $redemption['is_used'] ? 'Used' : 'Active'; ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="no-data">
                        <p>No redemptions yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script src="../assets/js/admin.js"></script>
</body>
</html>
