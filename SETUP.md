# Loyalty Reward Programme Setup Guide

## Prerequisites
- XAMPP installed and running
- Apache and MySQL services started

## Database Setup

### Option 1: Fresh Installation
1. **Open phpMyAdmin** (usually at http://localhost/phpmyadmin)
2. **Create the database:**
   - Click "New" in the left sidebar
   - Enter database name: `loyalty_db`
   - Click "Create"
3. **Import the schema:**
   - Select the `loyalty_db` database
   - Click "Import" tab
   - Choose file: `/sql/schema.sql`
   - Click "Go" to execute
4. **Import seed data:**
   - Stay in the `loyalty_db` database
   - Click "Import" tab again
   - Choose file: `/sql/seed.sql`
   - Click "Go" to execute

### Option 2: Update Existing Database (Remove Password Hashing)
If you already have the database set up but need to remove password hashing:

1. **Run the update script:**
   - Select the `loyalty_db` database in phpMyAdmin
   - Click "Import" tab
   - Choose file: `/sql/update_schema.sql`
   - Click "Go" to execute

## Configuration

1. **Update database credentials** in `/includes/config.php` if needed:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');        // Your MySQL username
   define('DB_PASS', '');            // Your MySQL password
   define('DB_NAME', 'loyalty_db');
   ```

## Testing the Setup

1. **Run system test:**
   - Visit: http://localhost/loyalty-reward-programme/test.php
   - Check all green checkmarks ✅
   - Delete test.php when done

2. **Test the homepage:**
   - Visit: http://localhost/loyalty-reward-programme/
   - Should see the new homepage with features

3. **Test user registration:**
   - Click "Join Now" on the homepage
   - Register a new account (gets 50 welcome bonus points)
   - Login and check the dashboard

4. **Test admin login:**
   - Visit: http://localhost/loyalty-reward-programme/admin/login.php
   - Username: `admin`
   - Password: `admin123`

## Sample Accounts (From Seed Data)

### Admin Accounts
- **Primary Admin:**
  - Username: `admin`
  - Password: `admin123`
  - Role: manager

- **Staff Account:**
  - Username: `staff1`
  - Password: `staff123`
  - Role: staff

### Sample User Accounts
- **John Smith:**
  - Email: `john@example.com`
  - Password: `password123`
  - Points: 150 pts

- **Sarah Johnson:**
  - Email: `sarah@example.com`
  - Password: `password123`
  - Points: 320 pts

- **Mike Wilson:**
  - Email: `mike@example.com`
  - Password: `password123`
  - Points: 520 pts

- **Emma Davis:**
  - Email: `emma@example.com`
  - Password: `password123`
  - Points: 1200 pts

## Sample Data Included
- **4 membership tiers:** Ketchup, Cheese, Bacon, Grill Master
- **5 earning rules:** Base rate, bonuses, multipliers
- **5 sample rewards:** Fries, drinks, discounts, combos
- **4 test users** with activity history
- **Sample point transactions** and redemptions

## Features Available

### For Members:
- ✅ User registration and login (no password hashing)
- ✅ Welcome bonus (50 points automatically)
- ✅ Birthday bonus (100 points per year)
- ✅ Points earning system (1 point per $1)
- ✅ Tier-based multipliers
- ✅ User dashboard with stats
- ✅ Profile management
- ✅ Activity ledger with transaction history
- ✅ Mobile responsive design

### For Admins:
- ✅ Admin dashboard with KPIs
- ✅ Member management
- ✅ Points awarding system
- ✅ Basic reporting
- ✅ Recent activity tracking

## System Architecture

```
Database Tables:
├── users (member accounts)
├── admin_user (admin accounts)
├── tier (membership levels)
├── points_ledger (all transactions)
├── reward (available rewards)
├── redemption (redeemed rewards)
├── earning_rule (point rules)
└── orders (purchase tracking)
```

## Key URLs

- **Homepage:** http://localhost/loyalty-reward-programme/
- **Member Registration:** http://localhost/loyalty-reward-programme/login/register.php
- **Member Login:** http://localhost/loyalty-reward-programme/login/login.php
- **Admin Login:** http://localhost/loyalty-reward-programme/admin/login.php
- **System Test:** http://localhost/loyalty-reward-programme/test.php

## Points System Rules

### Earning Points:
- **Base Rate:** 1 point per $1 spent
- **Welcome Bonus:** 50 points (one-time)
- **Birthday Bonus:** 100 points (yearly)
- **Tier Multipliers:**
  - Ketchup: 1.0x
  - Cheese: 1.1x (≥1,500 annual points)
  - Bacon: 1.25x (≥4,000 annual points)
  - Grill Master: 1.5x (≥8,000 annual points)

### Redemption Rules:
- Points expire after 12 months
- Max 2 redemptions per day
- Redemption codes expire in 14 days
- FIFO consumption (oldest points used first)

## Troubleshooting

### Database Connection Issues
- Ensure MySQL is running in XAMPP
- Check database credentials in config.php
- Verify database name exists

### Login Issues
- Clear browser cache and cookies
- Check if sessions are working
- Verify plain text passwords in database

### Permission Issues
- Ensure the project folder has proper read/write permissions
- Check file paths in includes

## Security Note
**Important:** This system stores passwords as plain text for educational purposes. For production use, implement:
- Password hashing
- Input sanitization
- CSRF protection
- SQL injection prevention
- Session security
- HTTPS encryption

## Next Steps
1. Customize rewards and tiers for your business
2. Add more admin functions (member search, reports)
3. Implement POS integration
4. Add email notifications
5. Create mobile app API endpoints
