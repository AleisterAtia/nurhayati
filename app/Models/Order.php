<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'payment_proof',
        'shipping_cost',
        'status',
        'shipping_address', // Ini wajib ada
        'payment_method',
    ];

public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * (Opsional) Relasi ke Order Items jika nanti dibutuhkan
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }


}
