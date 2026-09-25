<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
            
            $table->string('name');                            // ឈ្មោះទំនិញ (ឧ. ASUS ROG Strix G16)
            $table->string('sku')->unique();                  // លេខកូដទំនិញ (ឧ. ROG-G16-001)
            $table->string('barcode')->nullable()->unique();   // លេខបាកូដ (ឧ. 880609123456)
            $table->decimal('cost_price', 10, 2);             // តម្លៃដើមទិញចូល (ឧ. 1150.00)
            $table->decimal('selling_price', 10, 2);          // តម្លៃលក់ចេញ (ឧ. 1399.00)
            $table->integer('stock_quantity')->default(0);    // ចំនួនស្តុកសរុប
            $table->integer('min_stock_alert')->default(5);   // កម្រិតប្រកាសអាសន្នស្តុកតិច
            $table->integer('warranty_period_months')->default(12); // រយៈពេលធានាគិតជាខែ (ឧ. 12 or 24)
            $table->text('specifications')->nullable();        // លក្ខណៈបច្ចេកទេស (Core i7, 16GB, RTX 4060)
            $table->text('description')->nullable();          // ការពិពណ៌នាបន្ថែម
            $table->string('thumbnail')->nullable();          // រូបភាពមេ
            $table->enum('status', ['In Stock', 'Low Stock', 'Out of Stock', 'Discontinued'])->default('In Stock');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
