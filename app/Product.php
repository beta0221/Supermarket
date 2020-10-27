<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'group_Id','attribute_set_id',
        'description','price','slug','stock',
        'active',
    ];
}
