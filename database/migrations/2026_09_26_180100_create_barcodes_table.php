<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barcodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('barcode_number')->unique(); // លេខបាកូដ (ឧ. 8851234567890)
            $table->string('barcode_type')->default('CODE128'); // CODE128, EAN13, QR
            $table->boolean('is_primary')->default(true); // ជាបាកូដមេប្រចាំទំនិញ
            $table->integer('print_count')->default(0); // ចំនួនដងដែលបានបោះពុម្ព
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('barcodes');
    }
}
