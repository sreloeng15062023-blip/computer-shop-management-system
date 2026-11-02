<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Function up(): នឹងដំណើរការនៅពេលយើងរត់ពាក្យបញ្ជា "php artisan migrate"
     * វាមានតួនាទីបង្កើតតារាងឈ្មោះ "app_notifications"
     */
    public function up()
    {
        Schema::create('app_notifications', function (Blueprint $table) {
            
            // 1. លេខសម្គាល់ស្វ័យប្រវត្តិ (Auto-increment Primary Key ID: 1, 2, 3...)
            $table->id();

            // 2. user_id: ភ្ជាប់ទៅកាន់តារាង users ដើម្បីដឹងថាសារនេះជារបស់អ្នកណា
            // ->nullable(): មានន័យថាអាចទទេបាន (បើទទេ មានន័យថាសារទូទៅសម្រាប់បុគ្គលិកទាំងអស់មើលឃើញ)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

            // 3. title: ចំណងជើងនៃដំណឹង (ឧ. "Low Stock Alert", "New Sale Completed")
            $table->string('title');

            // 4. message: ខ្លឹមសារលម្អិតនៃដំណឹង (ប្រើ text() ព្រោះវាអាចផ្ទុកអក្សរវែងៗបាន)
            $table->text('message');

            // 5. type: ប្រភេទដំណឹងតាមលក្ខខណ្ឌ Assignment
            // (ឧ. 'Low Stock Alert', 'Warranty Expiry Reminder', 'Repair Completion', 'Promotion', 'Purchase Order Reminder')
            $table->string('type')->default('System Alert');

            // 6. category: សម្រាប់បែងចែក Tab លើអេក្រង់ UI (all, messages, system_alerts, reminders, others)
            $table->string('category')->default('system_alerts');

            // 7. icon & icon_color: រូបតំណាង និងពណ៌ក្នុងប្រអប់ UI (ឧ. fa-bell, ពណ៌ blue, emerald, amber, rose)
            $table->string('icon')->default('fa-bell');
            $table->string('icon_color')->default('blue');

            // 8. action_url & action_label: សម្រាប់ប៊ូតុងចុចទៅកាន់ទំព័រនោះភ្លាមៗ
            // (ឧ. ដំណឹងអស់ស្តុក ចុចប៊ូតុង "View Stock" នឹងរត់ទៅទំព័រ /inventory)
            $table->string('action_url')->nullable();
            $table->string('action_label')->nullable();

            // 9. is_read: ស្ថានភាពអាន (true = អានរួច, false = មិនទាន់អាន)
            $table->boolean('is_read')->default(false);

            // 10. read_at: កាលបរិច្ឆេទ និងម៉ោងដែលអ្នកប្រើបានចុចអាន
            $table->timestamp('read_at')->nullable();

            // 11. timestamps(): បង្កើតជួរឈរ ២ ស្វ័យប្រវត្តិគឺ created_at (ថ្ងៃបង្កើត) និង updated_at (ថ្ងៃកែប្រែ)
            $table->timestamps();
        });
    }

    /**
     * Function down(): ដំណើរការពេលយើងចង់លុបតារាងនេះចោលវិញ (Rollback)
     */
    public function down()
    {
        Schema::dropIfExists('app_notifications');
    }
};
