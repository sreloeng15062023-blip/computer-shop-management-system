<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('date'); // ថ្ងៃកត់ត្រាវត្តមាន
            $table->time('check_in')->nullable(); // ម៉ោងចូលធ្វើការ
            $table->time('check_out')->nullable(); // ម៉ោងចេញពីធ្វើការ
            $table->decimal('working_hours', 4, 2)->default(0.00); // ចំនួនម៉ោងធ្វើការ
            $table->enum('status', ['Present', 'Late', 'Absent', 'On Leave', 'Half Day'])->default('Present');
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
        Schema::dropIfExists('attendances');
    }
}
