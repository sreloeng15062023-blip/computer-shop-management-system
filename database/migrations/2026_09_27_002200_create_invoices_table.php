<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // លេខកូដវិក្កយបត្រ (ឧ. INV-2026-0001 ឬ INV-2025-0098)
            $table->foreignId('sale_id')->nullable()->constrained('sales')->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // អ្នកចេញវិក្កយបត្រ
            $table->dateTime('invoice_date'); // ថ្ងៃខែម៉ោងចេញវិក្កយបត្រ
            $table->date('due_date')->nullable(); // កាលបរិច្ឆេទទូទាត់ចុងក្រោយ
            $table->decimal('subtotal', 12, 2)->default(0.00); // តម្លៃដើម
            $table->decimal('discount_amount', 12, 2)->default(0.00); // បញ្ចុះតម្លៃ
            $table->decimal('tax_amount', 12, 2)->default(0.00); // ពន្ធ (Tax 10%)
            $table->decimal('total_amount', 12, 2)->default(0.00); // តម្លៃសរុបត្រូវបង់
            $table->decimal('paid_amount', 12, 2)->default(0.00); // ទឹកប្រាក់បានបង់រួច
            $table->decimal('balance_due', 12, 2)->default(0.00); // ទឹកប្រាក់នៅខ្វះ (Outstanding Balance)
            $table->enum('payment_method', ['Cash', 'Card', 'ABA', 'Wing', 'QR', 'Other'])->default('Cash');
            $table->enum('status', ['Paid', 'Pending', 'Cancelled', 'Refunded'])->default('Paid');
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
        Schema::dropIfExists('invoices');
    }
}
