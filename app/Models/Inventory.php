<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'store_id', 'user_id', 'supplier_id',
        'current_stock', 'stock_added', 'new_stock', 'date_added', 'status'
    ]; 
    // Defines which fields can be mass-assigned when creating/updating an inventory record.

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    // Each inventory record belongs to a product.

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
    // Each inventory record belongs to a store.

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // Each inventory record belongs to a user who updated stock.

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
