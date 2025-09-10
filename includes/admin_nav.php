    <nav class="nav-bar">
        <div class="nav-toggle">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>

        <div class="greeting">
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></p>
        </div>
        <div class="logo">
            <img src="/assets/img/icon.png" alt="">
            <img src="/assets/img/logo.png" alt="">
        </div>


        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="members.php">Manage Users</a>
            <a href="#">Manage Rewards</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>