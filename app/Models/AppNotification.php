<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppNotification extends Model
{
    use HasFactory;

    // ១. ប្រាប់ Laravel ឱ្យស្គាល់ឈ្មោះតារាងក្នុង MySQL
    // (ដោយសារឈ្មោះ Model គឺ AppNotification ដូច្នេះតារាងរបស់វាគឺ app_notifications)
    protected $table = 'app_notifications';

    // ២. $fillable: បញ្ជីឈ្មោះជួរឈរ (Columns) ដែលអនុញ្ញាតឱ្យបញ្ចូលទិន្នន័យបាន
    // ការពារកុំឱ្យ Hacker លួចចាក់ទិន្នន័យផ្តេសផ្តាសចូល Database
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'category',
        'icon',
        'icon_color',
        'action_url',
        'action_label',
        'is_read',
        'read_at',
    ];

    // ៣. $casts: បំប្លែងប្រភេទ Data Type ពី MySQL មកជា PHP ស្វ័យប្រវត្តិ
    // ឧ. នៅក្នុង Database លេខ 0 ឬ 1 ពេលទាញមកកូដ PHP វានឹងស្គាល់ជា false (មិនទាន់អាន) ឬ true (អានរួច)
    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    // ៤. Relationship: ភ្ជាប់ទំនាក់ទំនងទៅកាន់ User
    // បញ្ជាក់ថាសារ Notification នេះ ជារបស់ User ណាម្នាក់
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}






