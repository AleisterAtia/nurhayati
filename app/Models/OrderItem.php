<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    /**
     * Relasi ke model Order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke model Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
