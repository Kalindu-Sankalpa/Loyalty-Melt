-- Seed data for Loyalty Reward Programme
USE loyalty_db;

-- Insert default tiers
INSERT INTO tier (name, color, points_required, min_annual_points, multiplier, benefits, active) VALUES
('Ketchup', '#FF6B35', 0, 0, 1.00, 'Standard benefits and basic rewards', 1),
('Cheese', '#FFD93D', 500, 1500, 1.10, 'Extra birthday +50 pts and enhanced rewards', 1),
('Bacon', '#A8E6CF', 1000, 4000, 1.25, 'Priority support and exclusive offers', 1),
('Grill Master', '#FF8B94', 2000, 8000, 1.50, 'VIP treatment and surprise quarterly perks', 1);

-- Insert default admin user (username: admin, password: admin123)
INSERT INTO admin_user (username, password, role) VALUES
('admin', 'admin123', 'manager'),
('staff1', 'staff123', 'staff');

-- Insert default earning rules
INSERT INTO earning_rule (name, type, amount, min_spend, active, notes) VALUES
('Base Earning Rate', 'base', 1.00, 0, 1, '1 point per $1 spent'),
('Welcome Bonus', 'bonus', 50, 0, 1, 'One-time bonus for new members'),
('Birthday Bonus', 'bonus', 100, 0, 1, 'Annual birthday bonus'),
('Combo Bonus', 'bonus', 25, 0, 1, 'Bonus for combo meals'),
('Happy Hour', 'multiplier', 2.00, 0, 1, 'Weekdays 2-5 PM double points');

-- Insert sample rewards
INSERT INTO reward (name, category, points_cost, description, image_path, terms, stock, is_active) VALUES
('Free Small Fries', 'Sides', 100, 'Get a free small portion of our crispy golden fries', 'assets/images/fries.jpg', 'Valid for 14 days. One-time use only.', 50, 1),
('Free Soft Drink', 'Beverages', 120, 'Choose any soft drink from our selection', 'assets/images/drink.jpg', 'Valid for 14 days. One-time use only.', 30, 1),
('$5 Off Any Burger', 'Discount', 250, 'Get $5 off any burger from our menu', 'assets/images/burger-discount.jpg', 'Valid for 14 days. Cannot combine with other offers.', NULL, 1),
('Classic Burger Combo', 'Meals', 600, 'Our signature burger with fries and drink', 'assets/images/combo.jpg', 'Valid for 14 days. One-time use only.', 20, 1),
('Free Birthday Burger', 'Special', 500, 'Special birthday treat - any burger free', 'assets/images/birthday-burger.jpg', 'Valid only during birthday month.', 10, 1);

-- Insert sample users for testing
INSERT INTO users (name, email, phone, password, dob, marketing_opt_in, tier_id, points_balance, annual_points) VALUES
('John Smith', 'john@example.com', '1234567890', 'password123', '1990-05-15', 1, 1, 150, 850),
('Sarah Johnson', 'sarah@example.com', '1234567891', 'password123', '1995-08-22', 1, 2, 320, 1850),
('Mike Wilson', 'mike@example.com', '1234567892', 'password123', '1988-12-03', 0, 3, 520, 4200),
('Emma Davis', 'emma@example.com', '1234567893', 'password123', '1992-03-10', 1, 4, 1200, 9500);

-- Insert sample point transactions for the test users
INSERT INTO points_ledger (user_id, delta, balance_after, reason, description, reference, expires_at, created_at) VALUES
(1, 50, 50, 'Welcome Bonus', 'New member welcome bonus', 'WELCOME-001', DATE_ADD(NOW(), INTERVAL 12 MONTH), DATE_SUB(NOW(), INTERVAL 30 DAY)),
(1, 100, 150, 'Purchase', 'Burger combo purchase', 'ORDER-001', DATE_ADD(NOW(), INTERVAL 12 MONTH), DATE_SUB(NOW(), INTERVAL 25 DAY)),
(2, 50, 50, 'Welcome Bonus', 'New member welcome bonus', 'WELCOME-002', DATE_ADD(NOW(), INTERVAL 12 MONTH), DATE_SUB(NOW(), INTERVAL 45 DAY)),
(2, 150, 200, 'Purchase', 'Large order with extras', 'ORDER-002', DATE_ADD(NOW(), INTERVAL 12 MONTH), DATE_SUB(NOW(), INTERVAL 20 DAY)),
(2, 120, 320, 'Purchase', 'Family meal purchase', 'ORDER-003', DATE_ADD(NOW(), INTERVAL 12 MONTH), DATE_SUB(NOW(), INTERVAL 10 DAY)),
(3, 50, 50, 'Welcome Bonus', 'New member welcome bonus', 'WELCOME-003', DATE_ADD(NOW(), INTERVAL 12 MONTH), DATE_SUB(NOW(), INTERVAL 60 DAY)),
(3, 200, 250, 'Purchase', 'Multiple burger order', 'ORDER-004', DATE_ADD(NOW(), INTERVAL 12 MONTH), DATE_SUB(NOW(), INTERVAL 15 DAY)),
(3, 270, 520, 'Purchase', 'Catering order', 'ORDER-005', DATE_ADD(NOW(), INTERVAL 12 MONTH), DATE_SUB(NOW(), INTERVAL 5 DAY)),
(4, 50, 50, 'Welcome Bonus', 'New member welcome bonus', 'WELCOME-004', DATE_ADD(NOW(), INTERVAL 12 MONTH), DATE_SUB(NOW(), INTERVAL 90 DAY)),
(4, 500, 550, 'Purchase', 'Large corporate order', 'ORDER-006', DATE_ADD(NOW(), INTERVAL 12 MONTH), DATE_SUB(NOW(), INTERVAL 7 DAY)),
(4, 650, 1200, 'Purchase', 'Event catering order', 'ORDER-007', DATE_ADD(NOW(), INTERVAL 12 MONTH), DATE_SUB(NOW(), INTERVAL 2 DAY));

-- Insert sample redemptions
INSERT INTO redemption (user_id, reward_id, code, status, is_used, points_cost, issued_at, expires_at) VALUES
(2, 1, 'FRIES001', 'used', 1, 100, DATE_SUB(NOW(), INTERVAL 5 DAY), DATE_ADD(NOW(), INTERVAL 9 DAY)),
(3, 2, 'DRINK001', 'active', 0, 120, DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_ADD(NOW(), INTERVAL 12 DAY)),
(4, 3, 'BURGER01', 'active', 0, 250, NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY));
