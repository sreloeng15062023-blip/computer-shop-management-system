<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * User Eloquent Model
 *
 * Represents an employee / user of the Computer Shop Management System.
 * Uses Laravel Sanctum (HasApiTokens) for API Bearer token generation.
 */
class User extends Authenticatable
{
    // HasApiTokens: Enables Sanctum methods like createToken() and currentAccessToken()
    // HasFactory: Enables model factories for unit testing
    // Notifiable: Enables sending email or database notifications to the user
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable via User::create() or $user->update().
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Foreign key referencing the roles table
    ];

    /**
     * The attributes that should be hidden when serialized to JSON.
     * Prevents password hashes and session tokens from ever leaking over API responses.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationship: User belongs to a Role.
     *
     * Enables fetching the role using $user->role.
     * Example: $user->role->role_name returns 'Admin' or 'Cashier'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
