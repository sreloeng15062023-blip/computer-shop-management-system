<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Role Eloquent Model
 *
 * Represents an access control role (e.g. Admin, Manager, Sale Staff, Cashier, Technician).
 */
class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_name',
        'description',
        'status',
    ];

    /**
     * Relationship: A Role has many Users.
     *
     * Enables fetching all users assigned to this role via $role->users.
     * Example: Role::where('role_name', 'Cashier')->first()->users;
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
