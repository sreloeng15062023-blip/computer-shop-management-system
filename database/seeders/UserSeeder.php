<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

/**
 * Seeder: UserSeeder
 *
 * Purpose:
 * Creates default demo user accounts for testing authentication and RBAC.
 * Accounts created:
 * - Admin:      admin@shop.com   / password123
 * - Cashier:    cashier@shop.com / password123
 * - Technician: tech@shop.com    / password123
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Finds the corresponding Role IDs and creates or updates test users.
     *
     * @return void
     */
    public function run()
    {
        // 1. Fetch the Role models from the database
        $adminRole      = Role::where('role_name', 'Admin')->first();
        $cashierRole    = Role::where('role_name', 'Cashier')->first();
        $technicianRole = Role::where('role_name', 'Technician')->first();

        // 2. Define the sample users to seed
        $users = [
            [
                'name'              => 'Admin User',
                'email'             => 'admin@shop.com',
                'password'          => Hash::make('password123'), // Securely hash the password with bcrypt
                'role_id'           => $adminRole ? $adminRole->id : null,
                'email_verified_at' => now(), // Mark email as verified
            ],
            [
                'name'              => 'Cashier Staff',
                'email'             => 'cashier@shop.com',
                'password'          => Hash::make('password123'),
                'role_id'           => $cashierRole ? $cashierRole->id : null,
                'email_verified_at' => now(),
            ],
            [
                'name'              => 'Repair Technician',
                'email'             => 'tech@shop.com',
                'password'          => Hash::make('password123'),
                'role_id'           => $technicianRole ? $technicianRole->id : null,
                'email_verified_at' => now(),
            ],
        ];

        // 3. Save each user to the database using updateOrCreate to prevent duplicates
        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']], // Lookup by unique email
                $userData                        // Attributes to insert/update
            );
        }
    }
}
