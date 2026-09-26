<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $warehouses = [
            [
                'code' => 'WH-PP-MAIN',
                'name' => 'Main Warehouse Phnom Penh',
                'location' => 'Building #45, Russian Blvd, Tuol Kouk, Phnom Penh',
                'phone' => '023 889 900',
                'manager_name' => 'Sokha Rith',
                'capacity' => 5000,
                'status' => 'Active',
                'description' => 'Central logistics and storage facility for computers and wholesale shipments.',
            ],
            [
                'code' => 'WH-STORE-01',
                'name' => 'TechZone Showroom Storefront',
                'location' => 'Shop #12, St. 271, Boeng Keng Kang, Phnom Penh',
                'phone' => '098 776 655',
                'manager_name' => 'Chan Dara',
                'capacity' => 1200,
                'status' => 'Active',
                'description' => 'Front store inventory, display units and retail ready stock.',
            ],
            [
                'code' => 'WH-REPAIR-01',
                'name' => 'Hardware & Repair Center Depot',
                'location' => 'Ground Floor, St. 2004, Sen Sok, Phnom Penh',
                'phone' => '077 334 455',
                'manager_name' => 'Meng Ly',
                'capacity' => 800,
                'status' => 'Active',
                'description' => 'Warranty parts, diagnostic units, replacement GPUs, and spare components storage.',
            ],
        ];

        foreach ($warehouses as $wh) {
            Warehouse::updateOrCreate(['code' => $wh['code']], $wh);
        }
    }
}
