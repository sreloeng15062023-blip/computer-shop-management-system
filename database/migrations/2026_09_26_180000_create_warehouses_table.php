<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // ឧ. WH-PP01, WH-STORE, WH-REPAIR
            $table->string('name');           // ឈ្មោះឃ្លាំង (ឧ. Main Warehouse Phnom Penh)
            $table->string('location');       // ទីតាំង / អាសយដ្ឋាន
            $table->string('phone')->nullable();
            $table->string('manager_name')->nullable(); // អ្នកគ្រប់គ្រងឃ្លាំង
            $table->integer('capacity')->default(1000); // សមត្ថភាពផ្ទុកអតិបរមា
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('warehouses');
    }
}
