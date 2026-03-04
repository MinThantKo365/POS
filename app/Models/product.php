<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * This is defined explicitly to match the corrected migration.
     */
    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'description',
        'category_id',
        'stock',
        'image',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(category::class, 'category_id');
    }

    /**
     * Get the carts for the product.
     */
    public function carts()
    {
        return $this->hasMany(cart::class, 'product_id');
    }

    /**
     * Get the orders for the product.
     */
    public function orders()
    {
        return $this->hasMany(order::class, 'product_id');
    }
}
