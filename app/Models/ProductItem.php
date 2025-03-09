<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'serial_no', 'condition', 'assigned_to', 'user_id', 'status'
    ]; 
    // Defines which fields can be mass-assigned when creating/updating a product item.

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    // Each product item belongs to a product.

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    // Tracks which user/department this item is assigned to.

    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Tracks which user registered this product item.
}

