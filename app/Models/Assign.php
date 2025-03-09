<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'asset_id', 'assigned_by', 'assigned_at',
        'assign_condition', 'total_items', 'deadline', 'store_id', 'serial_no',
        'department_id', 'return_condition', 'return_reason', 'date_returned',
        'comment', 'status', 'approved_by', 'approved_at'
    ]; 

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(ProductItem::class, 'asset_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
