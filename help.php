<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/index.css"> 
    <link rel="stylesheet" href="/assets/css/help.css"> 
    <link rel="shortcut icon" href="/assets/img/icon.png" type="image/x-icon">
    <title>Help - <?php echo APP_NAME; ?></title>
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
            <a href="index.php#home" class="nav-item">Home</a>
            <a href="index.php#about" class="nav-item">About</a>
            <a href="index.php#rewards" class="nav-item">Rewards</a>
            <a href="index.php#contact" class="nav-item">Contact</a>
            <a href="help.php" class="nav-item active">Help</a> <!-- Active state for help link -->
            <div>
                <a href="user/login.php" class="nav-btn">Login</a>
                <a href="admin/login.php" class="nav-btn">Admin</a>
            </div>
        </div>
    </nav>

    <section class="help-hero">
        <div class="container">
            <h1>How Can We Help You?</h1>
            <p>Find answers to common questions about <?php echo APP_NAME; ?> loyalty program.</p>
        </div>
    </section>

    <section class="faq-section">
        <div class="container">
            <h2>Frequently Asked Questions</h2>

            <div class="faq-item">
                <h3 class="faq-question">How do I earn points?</h3>
                <div class="faq-answer">
                    <p>You earn points with every purchase at our burger shop. Typically, you'll receive 1 point for every $1 spent. Keep an eye out for special promotions where you can earn bonus points!</p>
                </div>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">What can I redeem my points for?</h3>
                <div class="faq-answer">
                    <p>Points can be redeemed for a variety of delicious rewards, including free small fries, soft drinks, discounts on burgers, and even full combo meals. Check the 'Rewards' section for the latest offerings.</p>
                </div>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">How do I check my points balance?</h3>
                <div class="faq-answer">
                    <p>You can check your current points balance by logging into your account on our website or by asking a staff member during your next visit.</p>
                </div>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">Do my points expire?</h3>
                <div class="faq-answer">
                    <p>Points are valid for 12 months from the date they are earned. Make sure to redeem them before they expire!</p>
                </div>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">How do I join the loyalty program?</h3>
                <div class="faq-answer">
                    <p>Joining is easy! Simply click on the 'Join Now' button on our homepage, fill out the registration form, and you'll start earning points immediately.</p>
                </div>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">Can I use my rewards online or only in-store?</h3>
                <div class="faq-answer">
                    <p>Currently, rewards can be redeemed in-store at any of our participating locations. We are working on expanding online redemption options in the future!</p>
                </div>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">I forgot my password, what should I do?</h3>
                <div class="faq-answer">
                    <p>On the login page, click the 'Forgot Password' link. You'll be prompted to enter your registered email address, and we'll send you instructions to reset your password.</p>
                </div>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">How do tier benefits work?</h3>
                <div class="faq-answer">
                    <p>As you earn more points, you'll climb through different membership tiers. Each tier offers enhanced benefits, such as higher point multipliers for purchases and exclusive rewards. You'll automatically be upgraded when you reach a new tier.</p>
                </div>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">How do I contact customer support?</h3>
                <div class="faq-answer">
                    <p>If you can't find the answer to your question here, please feel free to contact us via email at <a href="mailto:support@loyaltymelt.com">support@loyaltymelt.com</a> or call us at (555) 123-4567. Our support team is happy to help!</p>
                </div>
            </div>

        </div>
    </section>

    <!-- Re-use your existing footer -->
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

    <!-- Re-use your main script.js for nav toggle, and add help.js for Q&A interactivity -->
    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/help.js"></script>
</body>
</html>