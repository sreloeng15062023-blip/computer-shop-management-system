<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * បញ្ចូលទិន្នន័យគំរូនៃក្រុមហ៊ុនផ្គត់ផ្គង់កុំព្យូទ័រនៅកម្ពុជា
     *
     * @return void
     */
    public function run()
    {
        $suppliers = [
            [
                'name'         => 'PTC Computer Distribution',
                'contact_name' => 'Sok San',
                'phone'        => '012 345 678',
                'email'        => 'sales@ptc-computer.com.kh',
                'address'      => 'No. 250, Monivong Blvd, Phnom Penh',
                'status'       => 'Active',
            ],
            [
                'name'         => 'Anana Computer Co., Ltd',
                'contact_name' => 'Chan Borey',
                'phone'        => '023 211 543',
                'email'        => 'contact@ananacomputer.com',
                'address'      => 'No. 95, Preah Norodom Blvd, Phnom Penh',
                'status'       => 'Active',
            ],
            [
                'name'         => 'Chhay Hout Computer Trading',
                'contact_name' => 'Lim Heng',
                'phone'        => '017 888 999',
                'email'        => 'info@chhayhout.com',
                'address'      => 'No. 120, Kampuchea Krom Blvd, Phnom Penh',
                'status'       => 'Active',
            ],
            [
                'name'         => 'Synnex Distribution Cambodia',
                'contact_name' => 'Vannak Keo',
                'phone'        => '023 999 111',
                'email'        => 'distributor@synnex.com.kh',
                'address'      => 'Russian Confederation Blvd, Phnom Penh',
                'status'       => 'Active',
            ],
            [
                'name'         => 'Smart Tech Solutions Ltd',
                'contact_name' => 'Chea Socheat',
                'phone'        => '098 765 432',
                'email'        => 'sales@smarttech.kh',
                'address'      => 'Sihanouk Blvd, Phnom Penh',
                'status'       => 'Active',
            ],
            [
                'name'         => 'Global Hardware Supply',
                'contact_name' => 'John Miller',
                'phone'        => '085 222 333',
                'email'        => 'support@globalhardware.com',
                'address'      => 'Toul Kork, Phnom Penh',
                'status'       => 'Inactive',
            ],
        ];

        foreach ($suppliers as $item) {
            Supplier::updateOrCreate(['name' => $item['name']], $item);
        }
    }
}
