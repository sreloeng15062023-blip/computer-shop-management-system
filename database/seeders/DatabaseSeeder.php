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
        // 1. Seed Roles first so that the 'roles' table is populated with Admin, Cashier, etc.
        $this->call(RoleSeeder::class);

        // 2. Seed Users next so that users can be linked to the roles created above
        $this->call(UserSeeder::class);
    }
}
