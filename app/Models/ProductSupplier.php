<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;;

class ProductSupplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'supplier_id', 'quantity', 'num_in_stock', 'total_stock', 'condition', 'user_id'
    ]; 
    // Defines which fields can be mass-assigned when creating/updating a product supplier record.

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    // Each product supplier record belongs to a product.

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
    // Each product supplier record belongs to a supplier.

    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Tracks which user registered this supplier entry.
}
