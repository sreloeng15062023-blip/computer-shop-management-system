<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

/**
 * Seeder: RoleSeeder
 *
 * Purpose:
 * Inserts the default system roles defined in the Topic 22 specification:
 * 1. Admin      - Full system access, configuration, user management
 * 2. Manager    - Inventory, purchases, supplier management, reports
 * 3. Sale Staff - Product catalog, customer lookup, standard sales
 * 4. Cashier    - POS terminal, payments, invoices, refunds
 * 5. Technician - Repair service tracking, device diagnosis, spare parts
 */
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Iterates through the predefined list of roles and uses updateOrCreate()
     * so that running this seeder multiple times will not create duplicates.
     *
     * @return void
     */
    public function run()
    {
        // Define the 5 core roles required by Topic 22
        $roles = [
            [
                'role_name'   => 'Admin',
                'description' => 'Full administrative access to all 16 system modules and settings',
                'status'      => 'Active',
            ],
            [
                'role_name'   => 'Manager',
                'description' => 'Manages inventory, purchases, suppliers, reports, and staff operations',
                'status'      => 'Active',
            ],
            [
                'role_name'   => 'Sale Staff',
                'description' => 'Assists customers, manages product inquiries, and facilitates sales',
                'status'      => 'Active',
            ],
            [
                'role_name'   => 'Cashier',
                'description' => 'Operates POS terminal, processes payments, and issues receipts',
                'status'      => 'Active',
            ],
            [
                'role_name'   => 'Technician',
                'description' => 'Performs repair services, diagnostics, and manages spare parts usage',
                'status'      => 'Active',
            ],
        ];

        // Loop through each role and save it to the database
        foreach ($roles as $roleData) {
            // updateOrCreate searches by 'role_name'. If found, updates; if not found, creates.
            Role::updateOrCreate(
                ['role_name' => $roleData['role_name']], // Lookup key
                $roleData                                // Attributes to insert or update
            );
        }
    }
}
