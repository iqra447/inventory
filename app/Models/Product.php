<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'brand_id', 'category_id', 'product_type_id', 'store_id', 
        'user_id', 'condition', 'total_stock', 'current_stock', 'description', 'status'
    ]; 
    // Defines which fields can be mass-assigned when creating/updating a product.

    public function make(): BelongsTo
    {
        return $this->belongsTo(Make::class, 'make_id');
    }
    // A product belongs to a brand.

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    // A product belongs to a category.

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }
    // A product belongs to a product type.

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
    // A product is kept in a store.

    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Tracks which user registered or last modified the product.
}
