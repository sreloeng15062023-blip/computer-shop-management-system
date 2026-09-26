<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarrantyClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warranty_claims', function (Blueprint $table) {
            $table->id();
            $table->string('claim_code')->unique(); // លេខកូដទាមទារធានា (ឧ. CLM-2025-0012)
            $table->foreignId('warranty_id')->constrained('warranties')->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('repair_service_id')->nullable()->constrained('repair_services')->onDelete('set null');
            $table->date('claim_date'); // ថ្ងៃដាក់ពាក្យទាមទារ
            $table->text('issue_description'); // បញ្ហាដែលបានជួបប្រទះ
            $table->text('resolution_notes')->nullable(); // កំណត់ចំណាំដោះស្រាយ
            $table->enum('status', [
                'Pending',
                'In Progress',
                'Waiting Parts',
                'Diagnosing',
                'Approved',
                'Rejected',
                'Completed',
                'Cancelled'
            ])->default('In Progress');
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
        Schema::dropIfExists('warranty_claims');
    }
}
