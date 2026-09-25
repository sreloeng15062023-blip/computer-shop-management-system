<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Main DatabaseSeeder
 *
 * Purpose:
 * Coordinates the seeding process for the application database.
 * When you run `php artisan db:seed`, this class calls seeders in the correct
 * dependency order (roles first, then users who depend on those roles).
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Seed Roles first (Admin, Cashier, Technician, Manager)
        $this->call(RoleSeeder::class);

        // 2. Seed Users (Admin user linked to Admin role)
        $this->call(UserSeeder::class);

        // 3. Seed Brands (Asus, Dell, HP, MSI, etc.)
        $this->call(BrandSeeder::class);

        // 4. Seed Suppliers (PTC, Anana, Chhay Hout, etc.)
        $this->call(SupplierSeeder::class);

        // 5. Seed Customers (Retail & Wholesale customers)
        $this->call(CustomerSeeder::class);

        // 6. Seed Categories & Products
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
    }
}
