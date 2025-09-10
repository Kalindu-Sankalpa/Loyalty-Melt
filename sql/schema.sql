-- Loyalty Reward Programme Database Schema
-- Simple and beginner-friendly design

-- Create database
CREATE DATABASE IF NOT EXISTS loyalty_db;
USE loyalty_db;

-- Users table (customers/members)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15) NULL,
    password VARCHAR(100) NOT NULL,
    dob DATE,
    marketing_opt_in TINYINT DEFAULT 0,
    tier_id INT DEFAULT 1,
    annual_points INT DEFAULT 0,
    points_balance INT DEFAULT 0,
    joined_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Admin users table
CREATE TABLE admin_user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL,
    role VARCHAR(20) DEFAULT 'staff',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tiers table
CREATE TABLE tier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    color VARCHAR(7) DEFAULT '#4A90E2',
    points_required INT DEFAULT 0,
    min_annual_points INT DEFAULT 0,
    multiplier DECIMAL(3,2) DEFAULT 1.00,
    benefits TEXT,
    active TINYINT DEFAULT 1
);

-- Points ledger table (transaction history)
CREATE TABLE points_ledger (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    delta INT NOT NULL,
    balance_after INT DEFAULT 0,
    reason VARCHAR(255),
    description VARCHAR(255),
    reference VARCHAR(50),
    expires_at DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Rewards table
CREATE TABLE reward (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) DEFAULT 'Food',
    points_cost INT NOT NULL,
    description TEXT,
    image_path VARCHAR(255),
    terms TEXT,
    stock INT,
    is_active TINYINT DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Redemptions table
CREATE TABLE redemption (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    reward_id INT NOT NULL,
    code VARCHAR(10) UNIQUE NOT NULL,
    status VARCHAR(20) DEFAULT 'active',
    is_used TINYINT DEFAULT 0,
    points_cost INT NOT NULL,
    issued_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    used_at DATETIME,
    expires_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (reward_id) REFERENCES reward(id)
);

-- Earning rules table
CREATE TABLE earning_rule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(20) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    min_spend DECIMAL(10,2) DEFAULT 0,
    start_at DATETIME,
    end_at DATETIME,
    active TINYINT DEFAULT 1,
    notes TEXT
);

-- Orders table (optional for tracking purchases)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    receipt_no VARCHAR(50) UNIQUE NOT NULL,
    net_amount DECIMAL(10,2) NOT NULL,
    purchased_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Add indexes for better performance
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_phone ON users(phone);
CREATE INDEX idx_ledger_user_id ON points_ledger(user_id);
CREATE INDEX idx_ledger_created_at ON points_ledger(created_at);
CREATE INDEX idx_redemption_user_id ON redemption(user_id);
CREATE INDEX idx_redemption_code ON redemption(code);

-- Add foreign key constraints
ALTER TABLE users 
ADD CONSTRAINT fk_users_tier_id 
FOREIGN KEY (tier_id) REFERENCES tier(id) ON DELETE SET NULL;
