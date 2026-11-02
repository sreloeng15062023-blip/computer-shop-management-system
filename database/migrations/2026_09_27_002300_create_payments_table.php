<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number')->unique(); // លេខបង្កាន់ដៃទូទាត់ (ឧ. PAY-2026-0001)
            $table->foreignId('sale_id')->nullable()->constrained('sales')->onDelete('cascade');
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('amount', 12, 2); // ចំនួនទឹកប្រាក់ទូទាត់ ($)
            $table->enum('payment_method', ['Cash', 'Card', 'ABA', 'Wing', 'QR', 'Other'])->default('Cash'); // វិធីសាស្ត្រទូទាត់
            $table->dateTime('payment_date'); // ថ្ងៃខែម៉ោងទូទាត់
            $table->string('transaction_reference')->nullable(); // លេខកូដប្រតិបត្តិការធនាគារ (ឧ. ABA-TRX-XXXX)
            $table->enum('status', ['Completed', 'Pending', 'Refunded'])->default('Completed');
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
        Schema::dropIfExists('payments');
    }
}
