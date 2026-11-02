<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique(); // លេខកូដប័ណ្ណបញ្ជាទិញ (ឧ. PO-202609-001)
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('restrict');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // បុគ្គលិកអ្នកបញ្ជាទិញ
            $table->date('order_date'); // កាលបរិច្ឆេទបញ្ជាទិញ
            $table->date('expected_delivery_date')->nullable(); // ថ្ងៃរំពឹងថានឹងមកដល់
            $table->timestamp('received_date')->nullable(); // ថ្ងៃទទួលទំនិញជាក់ស្តែង
            $table->decimal('total_amount', 12, 2)->default(0.00); // តម្លៃសរុបនៃ PO
            $table->enum('status', ['Pending', 'Received', 'Cancelled'])->default('Pending'); // ស្ថានភាព PO
            $table->enum('payment_status', ['Unpaid', 'Partial', 'Paid'])->default('Unpaid'); // ស្ថានភាពទូទាត់
            $table->text('notes')->nullable(); // កំណត់សម្គាល់បន្ថែម
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
        Schema::dropIfExists('purchase_orders');
    }
}
