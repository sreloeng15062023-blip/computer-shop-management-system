<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    /**
     * ជួរឈរដែលអនុញ្ញាតឱ្យបញ្ចូលទិន្នន័យ (Mass Assignment)
     */
    protected $fillable = [
        'brand_name',
        'country',
        'description',
        'status',
    ];
    /**
     * ទំនាក់ទំនង៖ Brand មួយអាចមាន Products ច្រើន (One-to-Many)
     * (ទុកប្រើសម្រាប់ Phase 2 ពេលបង្កើត Product)
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
}
