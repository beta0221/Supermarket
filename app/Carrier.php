<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','price', 'delivery_text'
    ];

    public $timestamps = false;

    
}
