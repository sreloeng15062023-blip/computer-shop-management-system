<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $defaults = [
            // ១. General Settings (ដូចផ្ទាំងកណ្តាលនៃ Mockup ថ្មី)
            ['key' => 'system_name',        'value' => 'Computer Shop Management System', 'group' => 'general'],
            ['key' => 'shop_name',          'value' => 'TECHZONE',                        'group' => 'general'],
            ['key' => 'language',           'value' => 'en',                              'group' => 'general'],
            ['key' => 'timezone',           'value' => 'Asia/Phnom_Penh',                 'group' => 'general'],
            ['key' => 'default_currency',   'value' => 'USD',                             'group' => 'general'],
            ['key' => 'tax_rate',           'value' => '10.00',                           'group' => 'general'],
            ['key' => 'items_per_page',     'value' => '10',                              'group' => 'general'],
            ['key' => 'system_description', 'value' => 'A complete solution for managing computer shop operations including sales, inventory, purchase, warranty, repair service and more.', 'group' => 'general'],

            // ២. Shop Contact Information (ដូច Card ខាងស្តាំ)
            ['key' => 'shop_address',       'value' => '#123, Street 7, Siem Reap, Cambodia', 'group' => 'shop'],
            ['key' => 'shop_phone',         'value' => '+855 12 345 678',                     'group' => 'shop'],
            ['key' => 'shop_email',         'value' => 'info@techzone.com',                   'group' => 'shop'],
            ['key' => 'shop_website',       'value' => 'www.techzone.com',                    'group' => 'shop'],

            // ៣. System Features Toggles
            ['key' => 'feature_pos',          'value' => '1', 'group' => 'features'],
            ['key' => 'feature_purchase',     'value' => '1', 'group' => 'features'],
            ['key' => 'feature_repair',       'value' => '1', 'group' => 'features'],
            ['key' => 'feature_inventory',    'value' => '1', 'group' => 'features'],
            ['key' => 'feature_warranty',     'value' => '1', 'group' => 'features'],
            ['key' => 'feature_notification', 'value' => '1', 'group' => 'features'],
            ['key' => 'feature_multibranch',  'value' => '0', 'group' => 'features'],
            ['key' => 'feature_advreport',    'value' => '0', 'group' => 'features'],
        ];

        foreach ($defaults as $item) {
            Setting::updateOrCreate(['key' => $item['key']], $item);
        }
    }
}
