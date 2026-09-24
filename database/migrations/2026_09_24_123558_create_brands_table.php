<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {

            // ->unique() ៖ ការពារកុំឱ្យគេបញ្ចូលឈ្មោះ Brand ដូចគ្នាពីរដង (ឧ. មិនឱ្យមាន ASUS ពីរ)
            // ->nullable() ៖ មានន័យថាជួរឈរនេះមិនបង្ខំឱ្យបំពេញក៏បាន (អាចទទេបាន)
            // ->default('Active') ៖ បើគេមិនបានរើស Status ទេ ប្រព័ន្ធនឹងកំណត់យក Active ដោយស្វ័យប្រវត្តិ
            $table->id();// Primary Key (id)
            $table->string('brand_name', 50)->unique();             // ឈ្មោះ Brand (ហាមជាន់គ្នា)
            $table->string('country', 50)->nullable();              // ប្រទេសដើមកំណើត (ឧ. Taiwan, USA)
            $table->text('description')->nullable();                // ការពិពណ៌នា
            $table->enum('status', ['Active', 'Inactive'])->default('Active'); // ស្ថានភាព
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
}
