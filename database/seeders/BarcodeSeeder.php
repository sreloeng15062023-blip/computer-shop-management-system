<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Barcode;

class BarcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate or sync barcodes for existing products
        $products = Product::all();
        foreach ($products as $product) {
            $barcodeNumber = $product->barcode;

            if (empty($barcodeNumber)) {
                $barcodeNumber = '885' . str_pad($product->id, 8, '0', STR_PAD_LEFT) . rand(0, 9);
                $product->update(['barcode' => $barcodeNumber]);
            }

            Barcode::updateOrCreate(
                ['barcode_number' => $barcodeNumber],
                [
                    'product_id'   => $product->id,
                    'barcode_type' => 'CODE128',
                    'is_primary'   => true,
                    'print_count'  => 1,
                ]
            );
        }
    }
}
