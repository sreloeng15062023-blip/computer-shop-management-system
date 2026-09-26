<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSerial extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'serial_number', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
