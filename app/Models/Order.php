<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'orders';

    protected $fillable = [
        'legacy_id',
        'user_id',
        'name',
        'number',
        'email',
        'method',
        'address',
        'address2',
        'total_products',
        'total_price',
        'placed_on',
        'payment_status',
    ];

    protected $casts = [
        'total_price' => 'integer',
        'legacy_id' => 'integer',
    ];

    /**
     * Get the user that placed this order
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
