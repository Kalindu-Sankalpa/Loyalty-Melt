# Loyalty Reward Programme — Burger Shop Edition (No Libraries)

A simple, beginner-friendly PHP + MySQL web app for a burger shop to run a points-based loyalty programme. Pure PHP, MySQL, HTML, CSS, and vanilla JavaScript only — no external libraries, modules, or APIs.

---

## Why this exists
- Keep customers coming back with clear rewards (free fries, drinks, burgers).
- Make it easy for staff/admin to manage points, members, and rewards.
- Keep the codebase small and understandable for beginners.

---

## Scope levels

- MVP (Phase 1): Registration, Login, Dashboard (points), Earn points by receipt total, View ledger, Simple rewards list, Redeem reward, Admin manual point adjust, Basic KPIs, CSV export.
- Phase 2: Tiers with multipliers, Promo/happy-hour multipliers, Birthday bonus, Reward stock, Terms, Member search & filters.
- Phase 3: Earning rules engine (CRUD), Rewards catalog management (CRUD), Tier management (CRUD), Reports (LTV, liability), Multi-outlet support, POS CSV import.
- Phase 4: In-app notifications, Content pages, Basic audit logs, Scheduled expiries.

All phases stick to: No external libraries. Plain PHP and SQL only.

---

## Roles
- Customer (Member): register, log in, view/edit profile, view points/ledger, browse rewards, redeem.
- Admin (Shop Staff/Manager): view KPIs, manage members, adjust points, manage rewards/rules/tiers, run reports, export CSV.

---

## Burger-shop business rules (recommended defaults)

### Earning points
- Base earn: 1 point per $1 spent (after discounts, before points redemptions).
- Welcome bonus: +50 points on first completed profile.
- Birthday bonus: +100 points within birthday month (once per year).
- Combo bonus: +25 points if order contains a “Combo Meal”.
- Happy hour: 2x points weekdays 2–5 PM (configurable rule).
- Referral: +100 points to both if a new member enters a valid referral code at registration.
- Caps: Max 1,000 points earnable per receipt to reduce abuse.
- Returns/voids: Negative adjustments in ledger to reverse points from refunded orders.

### Redeeming points
- Example rewards (editable):
  - Free Small Fries — 100 pts
  - Free Soft Drink — 120 pts
  - $5 Off Any Burger — 250 pts
  - Classic Burger Combo — 600 pts
- Redemption rules:
  - Member must have >= points cost.
  - Deduct points immediately and issue a simple 8–10 char redemption code.
  - Code expires in 14 days; one-time use.
  - Max 2 redemptions per member per day.

### Tiers (annual progress)
- Ketchup (0+ annual pts): multiplier 1.0, standard benefits.
- Cheese (≥ 1,500 annual pts): multiplier 1.1, extra birthday +50 pts.
- Bacon (≥ 4,000 annual pts): multiplier 1.25, priority support.
- Grill Master (≥ 8,000 annual pts): multiplier 1.5, surprise quarterly perk.
- Annual points reset every Jan 1 for tier calculation; current tier lasts the year.

### Expiry & liability
- Earned points expire 12 months after earn date (first-in, first-out consumption).
- Unused redemption codes expire 14 days after issue.
- Show liability: total non-expired points outstanding.

### Basic fraud controls
- One account per unique phone number + email.
- Limit: at most 2 reward redemptions/day.
- Staff adjustments require an admin note (reason stored in ledger).
- Dont use any encryption things and dont think much about security because we want this just basic beginer level.
- Make sure you validate each things. like mobile numbers, emails using regex and also validate each points on forms in a correct flow.

---

## Functional requirements (tailored)

### Customer
- FR-U1: Register with name, email, phone, password; validate inputs; unique email & phone.
- FR-U2: View/edit profile (name, phone, email, DOB, marketing opt-in).
- FR-U3: Login/Logout (PHP sessions).
- FR-U4: View points balance on dashboard.
- FR-U5: View activity ledger (date/time, reason, +/- points, expiry for each bucket).
- FR-U6: Browse rewards catalog by category and points cost.
- FR-U7: View reward details (image, description, points cost, terms).
- FR-U8: Redeem reward (if balance sufficient); generate simple code; deduct points.
- FR-U9: View current tier and benefits.
- FR-U10: View progress to next tier (e.g., “You earned 1,350/1,500 points this year”).

### Admin
- FR-A1: Dashboard KPIs: total members, points issued (month), points redeemed (month), redemption count, simple charts (optional later), latest activity.
- FR-A2: Search/filter members by name/email/phone/tier/points/sign-up date.
- FR-A3: View member details: profile, full ledger, redemptions.
- FR-A4: Manual points adjustment (+/-) with required reason.
- FR-A5: Manual member enrollment (create account without email confirmation).
- FR-A6: Manage earning rules (CRUD): base rate, promos, multipliers, date ranges.
- FR-A7: Manage rewards (CRUD): name, cost, image path, description, terms, active/stock.
- FR-A8: Manage tiers (CRUD): thresholds, multipliers, benefits.
- FR-A9: Reports: Member acquisition, Points liability, Redemption rates, Member LTV (simple).
- FR-A10: Export any list/report to CSV (plain PHP output with headers).

---

## Pages and file structure (no frameworks)

Keep files small and focused. Suggested structure (build on your existing folders):

- `/index.php` — Landing with links to Login/Register and Rewards preview.
- `/login/`
  - `login.php` — Form; on success, redirect to dashboard.
  - `login_process.php` — Processes login; sets session.
  - `login.css` / `login.js`
- `/user/`
  - `dashboard.php` — Points, tier, progress, recent ledger, quick links.
  - `profile.php` — View/edit profile; update password.
  - `ledger.php` — Full transaction list with pagination.
  - `rewards.php` — Browse rewards; filter by category; go to detail.
  - `reward.php` — Reward details; Redeem button.
  - `redeem_confirm.php` — Shows issued code and instructions.
- `/admin/`
  - `login.php` — Separate admin login.
  - `dashboard.php` — KPIs + quick links.
  - `members.php` — Search/filter table.
  - `member_view.php` — Profile + ledger + adjust points.
  - `rewards.php` (list) / `reward_edit.php` (create/edit).
  - `rules.php` (list) / `rule_edit.php` (create/edit).
  - `tiers.php` (list) / `tier_edit.php` (create/edit).
  - `reports.php` — Run built-in reports.
  - `export.php` — CSV outputs.
- `/includes/`
  - `config.php` — DB credentials, app settings.
  - `db.php` — Create mysqli connection; helper for safe queries.
  - `auth.php` — Session helpers: require_login(), is_admin().
  - `csrf.php` — Create/validate CSRF tokens.
  - `points.php` — Core logic: earn, redeem, consume FIFO, compute tier.
  - `validation.php` — Simple input checks.
  - `helpers.php` — Common utilities (format money/points, random code generator).
  - `templates/` — `header.php`, `footer.php`, `nav_user.php`, `nav_admin.php`.
- `/assets/`
  - `css/`, `js/`, `images/` (reward images, logo).
- `/sql/`
  - `schema.sql` — Create tables.
  - `seed.sql` — Starter data (rewards, tiers, admin user).
- `/cron/`
  - `expire_points.php` — Mark expired point buckets daily.

Note: keep using your existing `Assets/` and `login/` folders; just add the new ones gradually.

---

## Data model (beginner-friendly, no SQL shown here)

Tables and key fields (keep types simple: INT, VARCHAR, DATETIME, DECIMAL(10,2)):

- users
  - id (PK), name, email (unique), phone (unique), password_hash, dob, marketing_opt_in (TINYINT), tier_id (FK tiers), annual_points (INT), points_balance (INT), joined_at, updated_at
- points_ledger
  - id (PK), user_id (FK), delta (INT, +earn/-redeem/-adjust), reason (text), reference (e.g., receipt no), expires_at (nullable), created_at, created_by (admin id or 0 for system)
- reward
  - id (PK), name, category, points_cost (INT), description, image_path, terms, stock (INT, nullable), active (TINYINT), created_at, updated_at
- redemption
  - id (PK), user_id (FK), reward_id (FK), code (unique), status (issued|used|expired), points_cost (INT), issued_at, used_at (nullable), expires_at
- tier
  - id (PK), name, min_annual_points (INT), multiplier (DECIMAL), benefits (text), active (TINYINT)
- earning_rule
  - id (PK), name, type (base|multiplier|bonus), amount (INT or DECIMAL), min_spend (DECIMAL), start_at, end_at, active (TINYINT), notes
- admin_user
  - id (PK), username (unique), password_hash, role (manager|staff), created_at
- outlet (optional for multi-store)
  - id (PK), name, address
- order (optional for CSV imports)
  - id (PK), user_id (FK), receipt_no (unique), net_amount (DECIMAL), purchased_at

Indexes: email, phone, user_id on ledger/redemption, reward_id on redemption, code unique, created_at for reports.

---

## Key flows (simple contracts)

- Earn points from receipt
  - Input: user_id, net_amount, timestamp, receipt_no
  - Steps: compute base points (+ multipliers), cap, add ledger entry with expires_at = +12 months, increment balance and annual_points, recompute tier
  - Output: new balance, ledger row id
- Redeem reward
  - Input: user_id, reward_id
  - Steps: check active and stock, check balance >= cost, FIFO consume expiring buckets, create redemption row with code, deduct balance, decrease stock
  - Output: redemption code and expiry date
- Daily expiry (cron)
  - Input: today
  - Steps: find unconsumed expiring buckets; create negative adjustments; mark expired
  - Output: adjusted balances

Edge cases to handle
- Duplicate receipt numbers (ignore or show message)
- Negative or zero order amounts (reject)
- Insufficient points on redeem
- Race conditions: double-click redeem (use CSRF + one-time token)
- Timezone consistency (store UTC, display local)

---



## Admin reports (starter set)
- Member acquisition by month (count of new users over time).
- Points liability: sum of non-expired positive ledger minus consumed/expired.
- Redemption rate: redemptions / issued points ratio by month.
- Member LTV (simple): sum of order net_amount per member.
- Top rewards: most redeemed items.

CSV export approach: set headers, echo column names, loop rows, comma-separate, escape quotes.

---

## UI notes (beginner-friendly)
- Keep forms simple, use required attributes, show inline errors.
- Use plain CSS; no frameworks. Mobile-first layout.
- Use small reusable templates for header/footer/navigation.
- Show points prominently with tier badge on dashboard.

---

## Minimal setup (XAMPP)
1) Create MySQL database (e.g., `loyalty_db`).
2) Create tables from `/sql/schema.sql` (to be added).
3) Update `/includes/config.php` with DB credentials.
4) Place project under `htdocs/loyalty-reward-programme/`.
5) Visit `http://localhost/loyalty-reward-programme/`.

---

## Roadmap checklist
- Phase 1 (MVP)
  - Auth (register/login/logout with sessions)
  - Profile (edit fields, password change)
  - Dashboard (balance, tier, last 5 ledger entries)
  - Earn by receipt form (admin or staff)
  - Redeem rewards + code issue
  - Admin KPIs + manual adjustments
  - CSV export for members, ledger, redemptions
- Phase 2
  - Tier multipliers + automatic tiering
  - Birthday and welcome bonuses
  - Rewards stock + terms
  - Member search & filters
- Phase 3
  - Earning rules UI (CRUD)
  - Rewards and tiers management (CRUD)
  - Reports set + better exports
  - Optional multi-outlet + POS CSV import
- Phase 4
  - In-app notifications
  - Audit logs for admin actions
  - Scheduled expiry job (daily)

---

## Glossary
- Points balance: current available points after all redemptions/adjustments.
- Annual points: points earned this calendar year (for tier calculations).
- Ledger: list of all point transactions (+ earn, - redeem, - expire, +/- adjust).
- FIFO: consume oldest points first when redeeming to minimize expiry loss.

---

## Implementation tips (pure PHP/MySQL)
- Keep business logic in `/includes/points.php` so it’s testable and reused.
- After any ledger change, recompute balance from ledger totals to avoid drift.
- Use transactions (`START TRANSACTION`, `COMMIT`, `ROLLBACK`) for redeem flow.
- Use simple numeric IDs and short text codes (A–Z, 0–9) for redemptions.

---

This document aligns the app to a burger shop with practical rules, a simple tech approach, and a clear path from MVP to a fuller programme — all without external libraries.
