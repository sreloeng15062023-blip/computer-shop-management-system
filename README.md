# Computer Shop Management System (Topic 22)

A comprehensive Web-Based Management System for a computer retail and repair shop, built with **Laravel (PHP)**, **MySQL**, **Blade Templates**, and **Tailwind CSS**.

Assignment for **Web App Framework (Year 2, Semester 2)**.

---

## 💻 Tech Stack
- **Framework**: Laravel 8 (PHP)
- **Database**: MySQL (28 Database Tables)
- **Frontend / Templating**: Laravel Blade + Tailwind CSS
- **Authentication**: Role-Based Access Control (RBAC) with 5 roles:
  - `Admin`
  - `Manager`
  - `Sale Staff`
  - `Cashier`
  - `Technician`

---

## 📋 16 Main Functional Modules
1. **User Authentication & RBAC**: Multi-role login, profile, password reset
2. **Dashboard**: Metrics for products, available stock, low stock alerts, repairs, and charts
3. **Product Management**: SKU, barcodes, serial numbers, categories, pricing
4. **Brand Management**: Dell, HP, Lenovo, ASUS, Acer, Apple, MSI, etc.
5. **Supplier Management**: Suppliers, purchase history, order tracking
6. **Customer Management**: Customer profiles, warranty history, loyalty points
7. **Purchase Management**: Purchase orders, receiving, status tracking
8. **Inventory Management**: Stock in, stock out, adjustments, serial tracking
9. **Sales Management (POS)**: POS terminal, discounts, coupons, receipts
10. **Repair Service Management**: Device intake, technician assign, repair status pipeline
11. **Warranty Management**: Registration, warranty verification, claim processing
12. **Payment & Invoice Management**: Invoicing, payment records, refunds
13. **Employee Management**: Attendance, schedules, salary, staff roles
14. **Report Management**: Daily/monthly sales, inventory, repairs, PDF/Excel export
15. **Notification System**: Low stock alerts, warranty reminders, repair completion
16. **Settings**: Shop details, tax configuration, currency, backup/restore database

---

## 🚀 Quick Start Guide

### 1. Prerequisites
- PHP >= 7.3 (PHP 8.0+ recommended)
- Composer
- MySQL (WampServer / XAMPP)
- Node.js & NPM

### 2. Setup Instructions

1. **Clone the repository**:
   ```bash
   git clone https://github.com/sreloeng15062023-blip/computer-shop-management-system.git
   cd computer-shop-management-system
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Configure environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Make sure your database credentials in `.env` match your local MySQL server:*
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=computer_shop_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Run migrations and seed default data**:
   ```bash
   php artisan migrate --seed
   ```

5. **Start the Laravel server**:
   ```bash
   php artisan serve
   ```
   *Open your browser at: **`http://127.0.0.1:8000`***

---

## 🔑 Demo User Accounts (Password: `password123`)

| Role | Email | Password | Access Level |
| :--- | :--- | :--- | :--- |
| **👑 Admin** | `admin@shop.com` | `password123` | Full access to all 16 modules & settings |
| **💳 Cashier** | `cashier@shop.com` | `password123` | POS Sales, Checkout, Payments, Receipts |
| **🔧 Technician** | `tech@shop.com` | `password123` | Repair tracking, diagnosis, parts used |
