<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSerialsTable extends Migration
{
    public function up()
    {
        Schema::create('product_serials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('serial_number')->unique(); // លេខ Serial ប្រចាំគ្រឿងនីមួយៗ (ឧ. SN-ASUS-998821)
            $table->enum('status', ['In Stock', 'Sold', 'Under Repair', 'Defective'])->default('In Stock');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_serials');
    }
}
