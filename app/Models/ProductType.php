<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'category_id', 'status'
    ]; 
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
