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

    /**
     * Check if user has a specific role by name (case-insensitive).
     *
     * @param string $roleName e.g. 'Admin', 'Cashier', 'Technician'
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role && strcasecmp($this->role->role_name, $roleName) === 0;
    }

    /**
     * Check if user has any of the given roles.
     * Example: $user->hasAnyRole('Admin', 'Manager')
     *
     * @param mixed ...$roles
     * @return bool
     */
    public function hasAnyRole(...$roles): bool
    {
        if (!$this->role) {
            return false;
        }

        $rolesList = is_array($roles[0] ?? null) ? $roles[0] : $roles;
        foreach ($rolesList as $r) {
            if (strcasecmp($this->role->role_name, trim($r)) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user is an Admin.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    /**
     * Check if the user is a Manager.
     */
    public function isManager(): bool
    {
        return $this->hasRole('Manager');
    }

    /**
     * Check if the user is a Cashier.
     */
    public function isCashier(): bool
    {
        return $this->hasRole('Cashier');
    }

    /**
     * Check if the user is a Repair Technician.
     */
    public function isTechnician(): bool
    {
        return $this->hasRole('Technician');
    }

    /**
     * Check if the user is Sale Staff.
     */
    public function isSaleStaff(): bool
    {
        return $this->hasRole('Sale Staff');
    }
}
