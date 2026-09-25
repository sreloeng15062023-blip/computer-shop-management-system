<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use App\Models\ProductSerial;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $laptopCat = Category::where('slug', 'laptops-notebooks')->first();
        $gpuCat    = Category::where('slug', 'graphic-cards')->first();
        $ramCat    = Category::where('slug', 'ram-memory')->first();

        $asusBrand = Brand::where('brand_name', 'like', '%ASUS%')->first();
        $msiBrand  = Brand::where('brand_name', 'like', '%MSI%')->first();
        $ptcSupplier = Supplier::first();

        $products = [
            [
                'category_id'            => $laptopCat ? $laptopCat->id : 1,
                'brand_id'               => $asusBrand ? $asusBrand->id : 1,
                'supplier_id'            => $ptcSupplier ? $ptcSupplier->id : null,
                'name'                   => 'ASUS ROG Strix G16 (2024)',
                'sku'                    => 'ROG-G16-RTX4060',
                'barcode'                => '880921001234',
                'cost_price'             => 1150.00,
                'selling_price'          => 1380.00,
                'stock_quantity'         => 8,
                'min_stock_alert'        => 3,
                'warranty_period_months' => 24,
                'specifications'         => 'Intel Core i7-13650HX | 16GB DDR5 | 1TB NVMe SSD | RTX 4060 8GB | 16" FHD+ 165Hz',
                'description'            => 'High-performance gaming laptop with ROG Intelligent Cooling.',
                'status'                 => 'In Stock',
                'serials'                => ['SN-ROG-G16-001', 'SN-ROG-G16-002', 'SN-ROG-G16-003'],
            ],
            [
                'category_id'            => $gpuCat ? $gpuCat->id : 1,
                'brand_id'               => $msiBrand ? $msiBrand->id : 1,
                'supplier_id'            => $ptcSupplier ? $ptcSupplier->id : null,
                'name'                   => 'MSI GeForce RTX 4070 SUPER Ventus 2X',
                'sku'                    => 'MSI-RTX4070S-V2X',
                'barcode'                => '880921005678',
                'cost_price'             => 560.00,
                'selling_price'          => 679.00,
                'stock_quantity'         => 12,
                'min_stock_alert'        => 4,
                'warranty_period_months' => 36,
                'specifications'         => '12GB GDDR6X | 192-bit | Dual Fan TORX 4.0 | DLSS 3 Support',
                'description'            => 'Ultra-fast graphics card designed for 1440p ray-traced gaming.',
                'status'                 => 'In Stock',
                'serials'                => ['SN-MSI-4070-001', 'SN-MSI-4070-002'],
            ],
        ];

        foreach ($products as $item) {
            $serials = $item['serials'] ?? [];
            unset($item['serials']);

            $product = Product::updateOrCreate(['sku' => $item['sku']], $item);

            foreach ($serials as $sn) {
                ProductSerial::updateOrCreate(['serial_number' => $sn], [
                    'product_id' => $product->id,
                    'status'     => 'In Stock',
                ]);
            }
        }
    }
}
