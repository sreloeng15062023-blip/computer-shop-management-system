<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Laptops & Notebooks', 'slug' => 'laptops-notebooks', 'description' => 'Gaming, Business and Ultrabook Laptops'],
            ['name' => 'Desktop PCs', 'slug' => 'desktop-pcs', 'description' => 'All-in-One and Custom Gaming PCs'],
            ['name' => 'Graphic Cards (GPU)', 'slug' => 'graphic-cards', 'description' => 'NVIDIA GeForce & AMD Radeon GPUs'],
            ['name' => 'Processors (CPU)', 'slug' => 'processors-cpu', 'description' => 'Intel Core and AMD Ryzen Processors'],
            ['name' => 'Monitors & Displays', 'slug' => 'monitors-displays', 'description' => '4K, 2K, 144Hz-360Hz Gaming Monitors'],
            ['name' => 'Storage & SSDs', 'slug' => 'storage-ssds', 'description' => 'NVMe M.2 SSDs, SATA SSDs, External HDDs'],
            ['name' => 'RAM / Memory', 'slug' => 'ram-memory', 'description' => 'DDR4 and DDR5 Desktop & Laptop RAM'],
            ['name' => 'Accessories & Peripherals', 'slug' => 'accessories', 'description' => 'Keyboards, Mice, Headsets, Webcams'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
