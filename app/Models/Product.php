<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'tgn-parfume';

    protected $fillable = [
        'legacy_id',
        'name',
        'details',
        'categories',
        'ingredient',
        'price',
        'image',
        'sold',
    ];

    protected $casts = [
        'price' => 'integer',
        'sold' => 'integer',
        'legacy_id' => 'integer',
    ];
}
