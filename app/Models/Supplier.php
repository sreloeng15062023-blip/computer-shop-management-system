<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * ឈ្មោះតារាងក្នុង Database
     */
    protected $table = 'suppliers';

    /**
     * The attributes that are mass assignable.
     * បញ្ជី Fields ដែលអនុញ្ញាតឱ្យបញ្ចូល ឬកែប្រែទិន្នន័យ (Mass Assignment)
     */
    protected $fillable = [
        'name',
        'contact_name',
        'phone',
        'email',
        'address',
        'status',
    ];
}
