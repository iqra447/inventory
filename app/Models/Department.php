<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Department extends Model
{
    use Hasfactory;
    protected $fillable = [
        'name','vote_code', 'description', 'parent_id', 'status', 'user_id'
    ];
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }
    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_id');
    }
    public function head():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
