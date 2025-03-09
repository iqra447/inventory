<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSerialNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'serial_no', 'color'
    ]; 
    // Defines which fields can be mass-assigned when creating/updating a product serial number.

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    // Each serial number belongs to a product.
}

