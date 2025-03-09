<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'upn', // Unique identifier
        'email',
        'department_id',
        'role',
        'is_superadmin',
        'status',
        'reason_for_deactivation',
        'last_seen_at',
        'permission_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * These will NOT be returned in API responses.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_superadmin' => 'boolean',
        'status' => 'integer',
        'last_seen_at' => 'datetime',
    ];

    /**
     * Relationship: A User belongs to a Department.
     * This creates a foreign key relationship.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}