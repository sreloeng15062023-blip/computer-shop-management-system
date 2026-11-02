<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_service_id',
        'product_id',
        'part_name',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected $casts = [
        'quantity'   => 'integer',
        'unit_price' => 'decimal:2',
        'subtotal'   => 'decimal:2',
    ];

    public function repairService()
    {
        return $this->belongsTo(RepairService::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
