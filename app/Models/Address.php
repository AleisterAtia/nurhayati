<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'recipient_name',
        'phone_number',
        'address_detail',
        'city',
        'disctrict',
        'province',
        'postal_code',
        
    ];

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
