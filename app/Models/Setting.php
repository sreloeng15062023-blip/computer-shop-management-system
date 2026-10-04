<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    /**
     * Helper Method ទី ១: Setting::get('key', 'default')
     * សម្រាប់ទាញយកតម្លៃ Setting មកប្រើកន្លែងណាផ្សេងក៏បាន
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Helper Method ទី ២: Setting::set('key', 'value', 'group')
     * សម្រាប់កត់ត្រា ឬអាប់ដេត Setting ដោយស្វ័យប្រវត្តិ
     */
    public static function set($key, $value, $group = 'general')
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
    }
}
