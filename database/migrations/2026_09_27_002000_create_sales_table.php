<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('sale_number')->unique(); // លេខកូដវិក្កយបត្រលក់ POS (ឧ. POS-2026-0001)
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null'); // អតិថិជន (អាចទទេសម្រាប់ Walk-in)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // បុគ្គលិកគិតលុយ (Cashier)
            $table->dateTime('sale_date'); // ថ្ងៃ និងម៉ោងលក់
            $table->decimal('subtotal', 12, 2)->default(0.00); // តម្លៃទំនិញសរុបមុនបញ្ចុះតម្លៃ និងពន្ធ
            $table->decimal('discount_percentage', 5, 2)->default(0.00); // ភាគរយបញ្ចុះតម្លៃ (%)
            $table->decimal('discount_amount', 12, 2)->default(0.00); // ទឹកប្រាក់បញ្ចុះតម្លៃ ($)
            $table->decimal('tax_percentage', 5, 2)->default(10.00); // ភាគរយពន្ធ (10%)
            $table->decimal('tax_amount', 12, 2)->default(0.00); // ទឹកប្រាក់ពន្ធ ($)
            $table->decimal('total_amount', 12, 2)->default(0.00); // តម្លៃទូទាត់សរុប ($)
            $table->decimal('paid_amount', 12, 2)->default(0.00); // ទឹកប្រាក់អតិថិជនបានបង់ជាក់ស្តែង
            $table->decimal('change_amount', 12, 2)->default(0.00); // ប្រាក់អាប់សងអតិថិជនវិញ
            $table->enum('payment_method', ['Cash', 'Card', 'ABA', 'Wing', 'QR', 'Other'])->default('Cash'); // វិធីសាស្ត្រទូទាត់
            $table->enum('payment_status', ['Paid', 'Partial', 'Pending'])->default('Paid'); // ស្ថានភាពទូទាត់
            $table->enum('status', ['Completed', 'Pending', 'Cancelled'])->default('Completed'); // ស្ថានភាពការលក់
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
        Schema::dropIfExists('sales');
    }
}
