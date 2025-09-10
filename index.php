<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="shortcut icon" href="/assets/img/icon.png" type="image/x-icon">
    <title><?php echo APP_NAME ?></title>
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <img src="/assets/img/icon.png" alt="Loyalty Link Logo">
            <img src="/assets/img/logo.png" alt="Loyalty Link Logo">
        </div>
        <div class="nav-toggle">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <div class="nav-links">
            <a href="#home" class="nav-item">Home</a>
            <a href="#about" class="nav-item">About</a>
            <a href="#rewards" class="nav-item">Rewards</a>
            <a href="#contact" class="nav-item">Contact</a>
            <!-- New Help link -->
            <a href="help.php" class="nav-item">Help</a>
            <div>
                <a href="user/login.php" class="nav-btn">Login</a>
                <a href="admin/login.php" class="nav-btn">Admin</a>
            </div>
        </div>
    </nav>

    <section id="home" class="hero">
        <h1>Welcome to the</h1>
        <div>
            <img src="/assets/img/icon.png" alt="Loyalty Link Logo">
            <img src="/assets/img/logo.png" alt="Loyalty Link Logo">
        </div>
        <p>Earn points with every purchase and unlock amazing rewards at your favorite burger shop!</p>
        <div class="hero-actions">
            <a href="user/register.php" class="btn-outline">Join Now</a>
            <a href="user/login.php" class="btn-fill">Sign In</a>
        </div>
    </section>

    <section class="features" id="about">
        <h2>Why Join <?php echo APP_NAME; ?></h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <h3>Earn Points</h3>
                <p>Get 1 point for every $1 spent. Tier multipliers give you even more!</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎁</div>
                <h3>Great Rewards</h3>
                <p>Free fries, drinks, burgers, and exclusive offers just for members.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🏆</div>
                <h3>Tier Benefits</h3>
                <p>Climb tiers for better multipliers and exclusive perks.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎉</div>
                <h3>Birthday Bonus</h3>
                <p>Special birthday rewards and bonus points during your birthday month.</p>
            </div>
        </div>
    </section>

    <section class="rewards-preview" id="rewards">
        <h2>Featured Rewards</h2>
        <div class="rewards-grid">
            <div class="reward-card">
                <div class="reward-image">🍟</div>
                <h3>Free Small Fries</h3>
                <p class="reward-cost">100 points</p>
                <p>Crispy golden fries, perfectly seasoned</p>
            </div>
            <div class="reward-card">
                <div class="reward-image">🥤</div>
                <h3>Free Soft Drink</h3>
                <p class="reward-cost">120 points</p>
                <p>Any soft drink from our selection</p>
            </div>
            <div class="reward-card">
                <div class="reward-image">🍔</div>
                <h3>$5 Off Burger</h3>
                <p class="reward-cost">250 points</p>
                <p>Discount on any burger from our menu</p>
            </div>
            <div class="reward-card">
                <div class="reward-image">🍽️</div>
                <h3>Classic Combo</h3>
                <p class="reward-cost">600 points</p>
                <p>Burger, fries, and drink combo</p>
            </div>
        </div>
        <div class="cta-section">
            <p>Ready to start earning rewards?</p>
            <a href="#home" class="btn btn-fill">Join Today</a>
        </div>
    </section>

    <footer id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <p>📧 support@loyaltymelt.com</p>
                    <p>📞 (555) 123-4567</p>
                    <p>📍 123 Burger Street, Food City</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <a href="user/login.php">Member Login</a>
                    <a href="user/register.php">Join Now</a>
                    <a href="admin/login.php">Admin Portal</a>
                </div>
                <div class="footer-section">
                    <div>
                        <img src="/assets/img/icon.png" alt="Loyalty Link Logo">
                        <img src="/assets/img/logo.png" alt="Loyalty Link Logo">
                    </div>
                    <p>Rewarding our customers, one point at a time.</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 <?php echo APP_NAME; ?>. A simple loyalty program for burger lovers.</p>
            </div>
        </div>
    </footer>

    <script src="/assets/js/script.js"></script>
</body>

</html>