<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // អ្នកធ្វើប្រតិបត្តិការ
            $table->enum('transaction_type', ['Stock In', 'Stock Out', 'Adjustment', 'Sale', 'Return']); // ប្រភេទប្រតិបត្តិការស្តុក
            $table->integer('quantity'); // ចំនួនប្រែប្រួល (ឧ. +10 ចូលស្តុក ឬ -2 ដកចេញ)
            $table->integer('stock_before'); // ចំនួនស្តុកមុនប្រតិបត្តិការ
            $table->integer('stock_after'); // ចំនួនស្តុកក្រោយប្រតិបត្តិការ
            $table->string('reference_type')->nullable(); // ឧ. PurchaseOrder, StockAdjustment, Sale
            $table->unsignedBigInteger('reference_id')->nullable(); // ID នៃឯកសារយោង (ឧ. purchase_order_id)
            $table->string('reason')->nullable(); // មូលហេតុ (ឧ. ទំនិញទិញចូល PO-001, ទំនិញខូច, រាប់ស្តុកឃើញលើស/ខ្វះ)
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
        Schema::dropIfExists('inventory_transactions');
    }
}
