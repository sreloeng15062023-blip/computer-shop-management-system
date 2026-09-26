<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';

    // អនុញ្ញាតឱ្យបញ្ចូលទិន្នន័យលើ Fields ទាំងនេះ
    protected $fillable =[
        'name',
        'phone',
        'email',
        'address',
        'customer_type',
        'points',
        'status'
    ];

    //កំណត់ Type Casting
    protected $casts=[
        'points'=>'integer',
        'created_at'=>'datetime',
        'updated_at'=>'datetime',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
