<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
            $table->integer('quantity'); // ចំនួនទំនិញដែលបានលក់
            $table->decimal('unit_price', 12, 2); // តម្លៃលក់ក្នុងមួយឯកតា ($)
            $table->decimal('subtotal', 12, 2); // សរុបទឹកប្រាក់ (quantity * unit_price)
            $table->integer('warranty_months')->default(12); // រយៈពេលធានាគិតជាខែ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_details');
    }
}
