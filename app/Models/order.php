<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'user_id',
        'count',
        'status',
        'order_code',
        'total_price',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the product in the order.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
