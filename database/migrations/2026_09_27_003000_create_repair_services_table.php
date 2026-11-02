<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_services', function (Blueprint $table) {
            $table->id();
            $table->string('repair_code')->unique(); // លេខកូដជួសជុល (ឧ. RE-2025-0098)
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('technician_id')->nullable()->constrained('users')->onDelete('set null'); // ជាងជួសជុល
            $table->string('device_type')->default('Laptop'); // Laptop, Desktop, Monitor, Phone, Printer, Component
            $table->string('brand')->nullable(); // ASUS, Dell, Logitech, MSI, etc.
            $table->string('model'); // ASUS TUF Gaming Laptop, etc.
            $table->string('serial_number')->nullable(); // Serial Number
            $table->text('issue_description'); // រោគសញ្ញាខូច (Issue)
            $table->text('diagnosis')->nullable(); // ការវិនិច្ឆ័យរបស់ជាង
            $table->enum('status', [
                'Received',
                'Diagnosing',
                'Waiting for Parts',
                'Repairing',
                'Testing',
                'Ready for Pickup',
                'Completed',
                'Cancelled'
            ])->default('Received');
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->date('estimated_completion')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->decimal('service_fee', 10, 2)->default(0.00); // ថ្លៃឈ្នួលជួសជុល
            $table->decimal('parts_total', 10, 2)->default(0.00); // ថ្លៃគ្រឿងបន្លាស់សរុប
            $table->decimal('total_cost', 10, 2)->default(0.00); // ថ្លៃសរុប
            $table->enum('payment_status', ['Unpaid', 'Paid', 'Partial'])->default('Unpaid');
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
        Schema::dropIfExists('repair_services');
    }
}
