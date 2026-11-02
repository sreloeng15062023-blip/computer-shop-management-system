<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $customers = [
            [
                'name'          => 'Sok Chantha',
                'phone'         => '012 888 999',
                'email'         => 'chantha.sok@gmail.com',
                'address'       => 'Sangkat Boeung Keng Kang 1, Khan BKK, Phnom Penh',
                'customer_type' => 'Retail',
                'points'        => 250,
                'status'        => 'Active',
            ],
            [
                'name'          => 'Tech Solution Co., Ltd',
                'phone'         => '023 999 111',
                'email'         => 'info@techsolution.com.kh',
                'address'       => 'Russian Blvd, Sangkat Teuk Thla, Khan Sen Sok, Phnom Penh',
                'customer_type' => 'Wholesale',
                'points'        => 1200,
                'status'        => 'Active',
            ],
            [
                'name'          => 'Keo Pich Pisey',
                'phone'         => '098 777 666',
                'email'         => 'pisey.keo@yahoo.com',
                'address'       => 'St 271, Sangkat Toul Tumpoung 2, Khan Chamkarmon, Phnom Penh',
                'customer_type' => 'Retail',
                'points'        => 80,
                'status'        => 'Active',
            ],
            [
                'name'          => 'Angkor Gaming Hub',
                'phone'         => '010 333 444',
                'email'         => 'angkor.gaming@gmail.com',
                'address'       => 'Sivutha Rd, Svay Dangkum, Siem Reap',
                'customer_type' => 'Wholesale',
                'points'        => 3500,
                'status'        => 'Active',
            ],
            [
                'name'          => 'Meng Sovannarith',
                'phone'         => '077 555 222',
                'email'         => 'sovannarith.meng@outlook.com',
                'address'       => 'Khan Chbar Ampov, Phnom Penh',
                'customer_type' => 'Retail',
                'points'        => 0,
                'status'        => 'Inactive',
            ],
        ];

        foreach ($customers as $data) {
            Customer::updateOrCreate(['phone' => $data['phone']], $data);
        }
    }
}
