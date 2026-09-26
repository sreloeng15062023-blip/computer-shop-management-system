<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    use HasFactory;

    protected $fillable = [
        'warranty_code',
        'product_id',
        'customer_id',
        'sale_id',
        'serial_number',
        'product_name',
        'brand',
        'purchase_date',
        'warranty_period_months',
        'expiry_date',
        'status',
        'terms',
    ];

    protected $casts = [
        'purchase_date'          => 'date',
        'expiry_date'            => 'date',
        'warranty_period_months' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function claims()
    {
        return $this->hasMany(WarrantyClaim::class);
    }
}
