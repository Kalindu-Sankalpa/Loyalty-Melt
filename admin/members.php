<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/format.php';

// Check if admin is logged in
requireAdminLogin();

// Pagination settings
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$whereClause = '';
$params = [];

if (!empty($search)) {
    $whereClause = "WHERE u.name LIKE ? OR u.email LIKE ? OR u.phone LIKE ?";
    $searchParam = "%$search%";
    $params = [$searchParam, $searchParam, $searchParam];
}

// Get total count for pagination
$countQuery = "SELECT COUNT(*) as count FROM users u $whereClause";
$totalMembers = $params ? getRow($countQuery, $params)['count'] : getRow($countQuery)['count'];
$totalPages = ceil($totalMembers / $limit);

// Get members data with tier information
$query = "
    SELECT 
        u.id, u.name, u.email, u.phone, u.points_balance, u.joined_at,
        t.name as tier_name, t.color as tier_color
    FROM users u 
    LEFT JOIN tier t ON u.tier_id = t.id 
    $whereClause
    ORDER BY u.joined_at DESC 
    LIMIT $limit OFFSET $offset
";

$members = $params ? getRows($query, $params) : getRows($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="/assets/css/member.css">
    <link rel="shortcut icon" href="/assets/img/logo.png" type="image/x-icon">
    <title>Manage Members - <?php echo APP_NAME; ?></title>
</head>

<body>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/admin_nav.php'; ?>

    <main class="admin-main">
        <div class="page-header">
            <h1>Manage Members</h1>
            <div class="action-header">
                <a href="/user/register.php" class="btn btn-fill">Add New Member</a>
            </div>
        </div>

        <div class="filters-section">
            <form method="GET" class="search-form">
                <div class="search-group">
                    <input type="text" name="search" placeholder="Search by name, email, or phone..."
                        value="<?php echo htmlspecialchars($search); ?>" class="search-input">
                    <button type="submit" class="btn btn-fill">Search</button>
                    <?php if (!empty($search)): ?>
                        <a href="members.php" class="btn btn-fill">Clear</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="stat-summary">
            <span class="stat-label">Total Members:</span>
            <span class="stat-value"><?php echo number_format($totalMembers); ?></span>
            <?php if (!empty($search)): ?>
                <span class="stat-note">(filtered results)</span>
            <?php endif; ?>
        </div>

        <?php if (!empty($members)): ?>
            <div class="activity-card table-responsive">
                <table class="">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Points</th>
                            <th>Tier</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $member): ?>
                            <tr>
                                <td class="member-name">
                                    <strong><?php echo htmlspecialchars($member['name']); ?></strong>
                                </td>
                                <td><?php echo htmlspecialchars($member['email']); ?></td>
                                <td><?php echo htmlspecialchars($member['phone'] ?? 'N/A'); ?></td>
                                <td class="points-cell">
                                    <span class="points-badge">
                                        <?php echo formatPoints($member['points_balance']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($member['tier_name']): ?>
                                        <span class="tier-badge" style="background-color: <?php echo $member['tier_color']; ?>">
                                            <?php echo htmlspecialchars($member['tier_name']); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="tier-badge">No Tier</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo formatDate($member['joined_at']); ?></td>
                                <td class="actions-cell">
                                    <div class="action-buttons">
                                        <a href="member_detail.php?id=<?php echo $member['id']; ?>"
                                            class="action-btn view" title="View Details">👁️</a>
                                        <a href="member_edit.php?id=<?php echo $member['id']; ?>"
                                            class="action-btn edit" title="Edit Member">✏️</a>
                                        <a href="delete_user.php?member_id=<?php echo $member['id']; ?>"
                                            class="action-btn points" title="Award Points">⛔</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>"
                            class="btn btn-outline">« Previous</a>
                    <?php endif; ?>

                    <div class="page-numbers">
                        <?php
                        $start = max(1, $page - 2);
                        $end = min($totalPages, $page + 2);

                        for ($i = $start; $i <= $end; $i++):
                        ?>
                            <a href="?page=<?php echo $i; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>"
                                class="page-btn <?php echo $i == $page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?php echo $page + 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>"
                            class="btn btn-outline">Next »</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="no-data">
                <?php if (!empty($search)): ?>
                    <h3>No members found</h3>
                    <p>No members match your search criteria "<?php echo htmlspecialchars($search); ?>"</p>
                    <a href="members.php" class="btn btn-primary">View All Members</a>
                <?php else: ?>
                    <h3>No members yet</h3>
                    <p>No members have joined the loyalty program yet.</p>
                    <a href="member_add.php" class="btn btn-primary">Add First Member</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>