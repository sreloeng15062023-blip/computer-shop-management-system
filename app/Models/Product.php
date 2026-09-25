<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'supplier_id',
        'name',
        'sku',
        'barcode',
        'cost_price',
        'selling_price',
        'stock_quantity',
        'min_stock_alert',
        'warranty_period_months',
        'specifications',
        'description',
        'thumbnail',
        'status',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'min_stock_alert' => 'integer',
        'warranty_period_months' => 'integer',
    ];

    // Relations
    public function category() { return $this->belongsTo(Category::class); }
    public function brand() { return $this->belongsTo(Brand::class); }
    public function supplier() { return $this->belongsTo(Supplier::class); }
    public function serials() { return $this->hasMany(ProductSerial::class); }
    public function images() { return $this->hasMany(ProductImage::class); }
}
