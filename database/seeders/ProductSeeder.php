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

            // -------------------------------------------------------------
            // គ្រឿងបន្លាស់កុំព្យូទ័រសម្រាប់ជួសជុល (Spare Parts for Repair Service)
            // -------------------------------------------------------------
            [
                'category_id'            => 1,
                'brand_id'               => 1,
                'supplier_id'            => 1,
                'name'                   => 'Kingston FURY Beast 8GB DDR4 3200MHz RAM',
                'sku'                    => 'RAM-KST-8GB-DDR4',
                'barcode'                => '880921009901',
                'cost_price'             => 18.00,
                'selling_price'          => 25.00,
                'stock_quantity'         => 20,
                'min_stock_alert'        => 5,
                'warranty_period_months' => 36,
                'specifications'         => '8GB DDR4 3200MHz Desktop / Laptop RAM',
                'description'            => 'High-quality replacement RAM memory for repairs.',
                'status'                 => 'In Stock',
                'serials'                => ['SN-RAM-8GB-001', 'SN-RAM-8GB-002'],
            ],
            [
                'category_id'            => 1,
                'brand_id'               => 1,
                'supplier_id'            => 1,
                'name'                   => 'Crucial 16GB DDR5 4800MHz Laptop RAM',
                'sku'                    => 'RAM-CRU-16GB-DDR5',
                'barcode'                => '880921009902',
                'cost_price'             => 36.00,
                'selling_price'          => 48.00,
                'stock_quantity'         => 15,
                'min_stock_alert'        => 3,
                'warranty_period_months' => 36,
                'specifications'         => '16GB SODIMM DDR5 4800MHz Laptop Memory',
                'description'            => 'High-speed memory module for laptop repairs.',
                'status'                 => 'In Stock',
                'serials'                => ['SN-RAM-16GB-001'],
            ],
            [
                'category_id'            => 1,
                'brand_id'               => 1,
                'supplier_id'            => 1,
                'name'                   => 'Samsung 980 512GB NVMe M.2 SSD',
                'sku'                    => 'SSD-SAM-512GB-M2',
                'barcode'                => '880921009903',
                'cost_price'             => 32.00,
                'selling_price'          => 45.00,
                'stock_quantity'         => 25,
                'min_stock_alert'        => 5,
                'warranty_period_months' => 60,
                'specifications'         => 'PCIe Gen 3.0 x4 NVMe M.2 2280 | Up to 3500MB/s',
                'description'            => 'Fast replacement solid state drive.',
                'status'                 => 'In Stock',
                'serials'                => ['SN-SSD-512GB-001', 'SN-SSD-512GB-002'],
            ],
            [
                'category_id'            => 1,
                'brand_id'               => 1,
                'supplier_id'            => 1,
                'name'                   => 'Arctic MX-4 Thermal Paste (4g)',
                'sku'                    => 'THM-ARC-MX4-4G',
                'barcode'                => '880921009904',
                'cost_price'             => 4.00,
                'selling_price'          => 8.00,
                'stock_quantity'         => 30,
                'min_stock_alert'        => 10,
                'warranty_period_months' => 0,
                'specifications'         => 'Thermal compound 8.5 W/(mK)',
                'description'            => 'Cooling maintenance thermal paste.',
                'status'                 => 'In Stock',
                'serials'                => [],
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
