<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'user_id',
        'role_id',
        'first_name',
        'last_name',
        'full_name',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'address',
        'position',
        'salary',
        'hire_date',
        'avatar',
        'status',
        'report_to',
        'notes',
    ];

    protected $casts = [
        'salary'        => 'decimal:2',
        'date_of_birth' => 'date',
        'hire_date'     => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function schedules()
    {
        return $this->hasMany(WorkSchedule::class);
    }
}
