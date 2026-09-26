<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantyClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'claim_code',
        'warranty_id',
        'customer_id',
        'repair_service_id',
        'claim_date',
        'issue_description',
        'resolution_notes',
        'status',
    ];

    protected $casts = [
        'claim_date' => 'date',
    ];

    public function warranty()
    {
        return $this->belongsTo(Warranty::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function repairService()
    {
        return $this->belongsTo(RepairService::class);
    }
}
