<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('shift_name'); // វេនព្រឹក (Morning Shift), វេនរសៀល (Afternoon Shift), ពេញម៉ោង (Full Day)
            $table->time('start_time'); // ម៉ោងចាប់ផ្តើម
            $table->time('end_time'); // ម៉ោងបញ្ចប់
            $table->string('work_days')->default('Monday - Saturday'); // ថ្ងៃធ្វើការ
            $table->date('effective_date')->nullable(); // កាលបរិច្ឆេទចាប់ផ្តើមអនុវត្ត
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
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
        Schema::dropIfExists('work_schedules');
    }
}
