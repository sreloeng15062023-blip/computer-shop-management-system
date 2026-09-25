<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // $table->string('phone')->unique()៖ ការពារកុំឱ្យចុះឈ្មោះអតិថិជនប្រើលេខទូរស័ព្ទជាន់គ្នា។
        // $table->enum('customer_type', ...)៖ បែងចែកអតិថិជនទិញរាយ (Retail) ឬទិញដុំ (Wholesale) សម្រាប់គណនាតម្លៃលក់ក្នុងម៉ូឌុល POS។
        // $table->integer('points')->default(0)៖ សម្រាប់សន្សំពិន្ទុអតិថិជន (Loyalty Points)។
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // ឈ្មោះអតិថិជន
            $table->string('phone')->unique();              // លេខទូរស័ព្ទ (មិនឱ្យស្ទួន)
            $table->string('email')->nullable();            // អ៊ីមែល (អាចទទេ)
            $table->text('address')->nullable();            // អាសយដ្ឋាន
            $table->enum('customer_type', ['Retail', 'Wholesale'])->default('Retail'); // ប្រភេទ (ទិញរាយ / ទិញដុំ)
            $table->integer('points')->default(0);          // ពិន្ទុសន្សំ Reward Points
            $table->enum('status', ['Active', 'Inactive'])->default('Active'); // ស្ថានភាព

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
        Schema::dropIfExists('customers');
    }
}
