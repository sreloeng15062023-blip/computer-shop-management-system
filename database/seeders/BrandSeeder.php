<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;// បន្ថែមពេលបង្កើត brand management
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            [
                'brand_name'  => 'ASUS',
                'country'     => 'Taiwan',
                'description' => 'Gaming laptops, ROG series, motherboards and PC components',
                'status'      => 'Active',
            ],
            [
                'brand_name'  => 'Dell',
                'country'     => 'USA',
                'description' => 'Business laptops, XPS series, and UltraSharp monitors',
                'status'      => 'Active',
            ],
            [
                'brand_name'  => 'MSI',
                'country'     => 'Taiwan',
                'description' => 'Gaming hardware, graphics cards, and gaming desktops',
                'status'      => 'Active',
            ],
            [
                'brand_name'  => 'Apple',
                'country'     => 'USA',
                'description' => 'MacBook Pro, Mac Studio, iMac and Apple Silicon devices',
                'status'      => 'Active',
            ],
            [
                'brand_name'  => 'Logitech',
                'country'     => 'Switzerland',
                'description' => 'Keyboards, mice, webcams, and gaming headsets',
                'status'      => 'Active',
            ],
            [
                'brand_name'  => 'Kingston',
                'country'     => 'USA',
                'description' => 'RAM Fury Beast, NVMe SSDs, and storage solutions',
                'status'      => 'Active',
            ],
        ];
        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['brand_name' => $brand['brand_name']], // ការពារកុំឱ្យ Duplicate
                $brand
            );
        }
    }
}