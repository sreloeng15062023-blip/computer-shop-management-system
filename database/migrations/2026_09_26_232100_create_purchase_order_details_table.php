<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
            $table->integer('quantity'); // ចំនួនបញ្ជាទិញ
            $table->decimal('unit_cost', 10, 2); // តម្លៃទិញចូលក្នុងមួយឯកតា
            $table->decimal('subtotal', 12, 2); // សរុបទឹកប្រាក់តាមមុខទំនិញ (quantity * unit_cost)
            $table->integer('received_quantity')->default(0); // ចំនួនដែលបានទទួលពិតប្រាកដ
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
        Schema::dropIfExists('purchase_order_details');
    }
}
