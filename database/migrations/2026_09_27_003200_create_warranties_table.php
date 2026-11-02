<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarrantiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warranties', function (Blueprint $table) {
            $table->id();
            $table->string('warranty_code')->unique(); // លេខប័ណ្ណធានា (ឧ. WAR-2025-0001)
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('sale_id')->nullable()->constrained('sales')->onDelete('set null');
            $table->string('serial_number')->index(); // Serial number
            $table->string('product_name');
            $table->string('brand')->nullable();
            $table->date('purchase_date'); // ថ្ងៃទិញ
            $table->integer('warranty_period_months')->default(12); // រយៈពេលធានា (គិតជាខែ)
            $table->date('expiry_date'); // ថ្ងៃផុតកំណត់ធានា
            $table->enum('status', ['Active', 'Expiring', 'Claimed', 'Expired'])->default('Active');
            $table->text('terms')->nullable();
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
        Schema::dropIfExists('warranties');
    }
}
