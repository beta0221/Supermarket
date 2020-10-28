<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'group_id',
        'attribute_set_id',
        'name',
        'description',
        'tax_id',
        'price',
        'stock',
        'active',
    ];

    public static $key = 'sku';
}
