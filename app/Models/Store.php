<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'phone_number', 'email', 'department_id', 'status', 'user_id'
    ];
    
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

