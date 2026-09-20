# Database Architecture & ERD

This directory contains the database design assets and Entity Relationship Diagrams (ERD) for the Computer Shop Management System.

## Database Overview
- **Database Engine**: MySQL (InnoDB)
- **Total Tables**: 28 Tables
- **Key Modules**:
  - Authentication & Roles (users, roles, permissions, personal_access_tokens)
  - Catalog (products, categories, brands, product_serials, barcodes)
  - Procurement (suppliers, purchase_orders, purchase_order_items)
  - Inventory (stock_movements, stock_adjustments, warehouses)
  - Customers & Loyalty (customers, loyalty_points, loyalty_tiers)
  - Sales & POS (sales, sale_items, payments, invoices, discounts, coupons)
  - Repairs (repair_requests, repair_diagnoses, repair_spare_parts, repair_statuses)
  - Warranty (warranties, warranty_claims)
  - Employees (employees, attendance, schedules)
  - System (settings, activity_logs, notifications)

## Files
- Place your exported ERD diagram (`erd_diagram.png` or `schema.sql`) in this directory.
