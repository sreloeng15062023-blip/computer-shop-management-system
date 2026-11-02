<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique(); // កូដសម្គាល់បុគ្គលិក (ឧ. EMP-001)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Login account
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null'); // Role
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name'); // ឈ្មោះពេញ
            $table->enum('gender', ['Male', 'Female', 'Other'])->default('Male');
            $table->date('date_of_birth')->nullable();
            $table->string('phone');
            $table->string('email')->unique();
            $table->text('address')->nullable();
            $table->string('position'); // តួនាទីការងារ (Store Manager, Sales Staff, etc.)
            $table->decimal('salary', 10, 2)->default(0.00); // ប្រាក់បៀវត្សរ៍ប្រចាំខែ
            $table->date('hire_date'); // ថ្ងៃចូលបម្រើការងារ
            $table->string('avatar')->nullable();
            $table->enum('status', ['Active', 'On Leave', 'Inactive', 'Terminated'])->default('Active');
            $table->string('report_to')->nullable(); // ឈ្មោះប្រធានផ្នែក
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
        Schema::dropIfExists('employees');
    }
}
