<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairService extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_code',
        'customer_id',
        'technician_id',
        'device_type',
        'brand',
        'model',
        'serial_number',
        'issue_description',
        'diagnosis',
        'status',
        'estimated_cost',
        'estimated_completion',
        'completed_at',
        'service_fee',
        'parts_total',
        'total_cost',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'estimated_cost'       => 'decimal:2',
        'service_fee'          => 'decimal:2',
        'parts_total'          => 'decimal:2',
        'total_cost'           => 'decimal:2',
        'estimated_completion' => 'date',
        'completed_at'         => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function parts()
    {
        return $this->hasMany(RepairPart::class);
    }

    public function warrantyClaims()
    {
        return $this->hasMany(WarrantyClaim::class);
    }
}
