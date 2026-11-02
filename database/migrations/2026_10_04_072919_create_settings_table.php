<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Function up(): បង្កើតតារាង settings ក្នុង MySQL
     * យើងរចនាតាមទម្រង់ Key-Value Store ដែលអនុញ្ញាតឱ្យផ្ទុកការកំណត់ទាំងអស់
     * ទាំង General Settings, Shop Info, និង System Features
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // key: ឈ្មោះសម្គាល់ Setting (ឧ. 'system_name', 'shop_name', 'tax_rate', 'timezone')
            $table->string('key')->unique();

            // value: តម្លៃនៃ Setting (ប្រើ longText ដើម្បីផ្ទុកបានទាំងអក្សរ និង JSON)
            $table->longText('value')->nullable();

            // group: ចាត់ក្រុម (general, shop, features, hours)
            $table->string('group')->default('general');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
