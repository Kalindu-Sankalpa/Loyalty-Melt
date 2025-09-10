<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/format.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/validation.php';

// Check if admin is logged in
requireAdminLogin();

$member_id = intval($_GET['id'] ?? 0);
if (!$member_id) {
    header('Location: members.php');
    exit;
}

// Get member details
$member = getRow("SELECT * FROM users WHERE id = ?", [$member_id]);
if (!$member) {
    header('Location: members.php');
    exit;
}

$errors = [];
$success = false;

// Get available tiers
$tiers = getRows("SELECT * FROM tier ORDER BY points_required ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="/assets/css/member.css">
    <link rel="shortcut icon" href="/assets/img/logo.png" type="image/x-icon">
    <title>Edit Member - <?php echo htmlspecialchars($member['name']); ?></title>
</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/admin_nav.php'; ?>
    
    <main class="admin-main">
        <div class="page-header">
            <h1>Edit Member</h1>
            <div class="header-actions">
                <a href="member_detail.php?id=<?php echo $member['id']; ?>" class="btn btn-outline">View Details</a>
                <a href="members.php" class="btn btn-outline">Back to Members</a>
            </div>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <strong>Success!</strong> Member has been updated successfully.
                <div class="alert-actions">
                    <a href="member_detail.php?id=<?php echo $member['id']; ?>" class="btn btn-primary">View Details</a>
                    <a href="members.php" class="btn btn-outline">Back to Members</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <strong>Error!</strong> Please fix the following issues:
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="edit-member-container">
            <!-- Member Summary -->
            <div class="member-summary">
                <div class="summary-header">
                    <div class="member-avatar">
                        <?php echo strtoupper(substr($member['name'], 0, 2)); ?>
                    </div>
                    <div class="member-info">
                        <h3><?php echo htmlspecialchars($member['name']); ?></h3>
                        <p>Member since <?php echo formatDate($member['joined_at']); ?></p>
                        <p class="current-points">Current Balance: <strong><?php echo formatPoints($member['points_balance']); ?></strong></p>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="form-container">
                <form method="POST" id="update-form" class="user-update-form">
                    <div class="form-section">
                        <h3>Personal Information</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="id" class="required">Member ID</label>
                                <input class="form-input desabled" type="text" id="id" name="id" 
                                       value="<?php echo $member_id; ?>" 
                                       placeholder="Member ID">
                            </div>

                            <div class="form-group">
                                <label for="name" class="required">Full Name</label>
                                <input class="form-input" type="text" id="name" name="name" 
                                       value="<?php echo htmlspecialchars($name ?? $member['name']); ?>" 
                                       placeholder="Enter member's full name" required>
                            </div>

                            <div class="form-group">
                                <label for="email" class="required">Email Address</label>
                                <input class="form-input" type="email" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($email ?? $member['email']); ?>" 
                                       placeholder="Enter email address" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input class="form-input" type="tel" id="phone" name="phone" 
                                       value="<?php echo htmlspecialchars($phone ?? $member['phone'] ?? ''); ?>" 
                                       placeholder="Enter phone number (optional)">
                                <small class="form-help">Optional - 10-15 digits</small>
                            </div>

                            <div class="form-group">
                                <label for="tier_id">Tier Assignment</label>
                                <select class="form-input" id="tier_id" name="tier_id">
                                    <option value="">No Tier</option>
                                    <?php foreach ($tiers as $tier): ?>
                                        <option value="<?php echo $tier['id']; ?>" 
                                                <?php echo ($tier['id'] == $member['tier_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($tier['name']); ?> 
                                            (<?php echo formatPoints($tier['points_required']); ?> pts required)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="form-help">Manually assign tier (overrides automatic tier assignment)</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Points Adjustment</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="points_adjustment">Points Adjustment</label>
                                <input class="form-input" type="number" id="points_adjustment" name="points_adjustment" 
                                       placeholder="0" step="1">
                                <small class="form-help">
                                    Enter positive number to add points, negative to deduct. 
                                    Current balance: <?php echo formatPoints($member['points_balance']); ?>
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="adjustment_reason">Adjustment Reason</label>
                                <input class="form-input" type="text" id="adjustment_reason" name="adjustment_reason" 
                                       placeholder="Reason for points adjustment">
                                <small class="form-help">Required if adjusting points</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-fill">Update Member</button>
                        <a href="member_detail.php?id=<?php echo $member['id']; ?>" class="btn btn-fill">Cancel</a>
                    </div>
                </form>
            </div>

            <!-- Recent Activity -->
            <div class="recent-activity">
                <h3>Recent Activity</h3>
                <?php 
                $recentActivity = getRows("
                    SELECT * FROM points_ledger 
                    WHERE user_id = ? 
                    ORDER BY created_at DESC 
                    LIMIT 5
                ", [$member_id]);
                ?>
                
                <?php if (!empty($recentActivity)): ?>
                    <div class="activity-list">
                        <?php foreach ($recentActivity as $activity): ?>
                            <div class="activity-item">
                                <div class="activity-info">
                                    <span class="activity-date"><?php echo formatDateTime($activity['created_at']); ?></span>
                                    <span class="activity-desc"><?php echo htmlspecialchars($activity['description'] ?? 'Transaction'); ?></span>
                                </div>
                                <div class="activity-points <?php echo $activity['delta'] > 0 ? 'positive' : 'negative'; ?>">
                                    <?php echo $activity['delta'] > 0 ? '+' : ''; ?><?php echo formatPoints($activity['delta']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="member_detail.php?id=<?php echo $member['id']; ?>" class="view-all-link">View Full History</a>
                <?php else: ?>
                    <p class="no-data">No recent activity.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script src="/assets/js/user_update.js"></script>
</body>
</html>
