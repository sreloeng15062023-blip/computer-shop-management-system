<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'barcode_number',
        'barcode_type',
        'is_primary',
        'print_count',
        'notes',
    ];

    /**
     * Relationship: The product this barcode belongs to
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
