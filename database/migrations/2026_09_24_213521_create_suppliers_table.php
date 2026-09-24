<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     * បង្កើតតារាង suppliers ក្នុង MySQL Database
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();                                    // SupplierID (Primary Key)
            $table->string('name', 100);                     // ឈ្មោះក្រុមហ៊ុនផ្គត់ផ្គង់ (e.g. PTC Computer, Anana)
            $table->string('contact_name', 100)->nullable(); // ឈ្មោះអ្នកតំណាង ឬអ្នកទាក់ទង
            $table->string('phone', 30);                     // លេខទូរស័ព្ទ
            $table->string('email', 100)->nullable();        // អ៊ីមែល
            $table->text('address')->nullable();             // អាសយដ្ឋានក្រុមហ៊ុន
            $table->enum('status', ['Active', 'Inactive'])->default('Active'); // ស្ថានភាព (Active/Inactive)
            $table->timestamps();                            // created_at និង updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}
