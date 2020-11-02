<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecificPrice extends Model
{
    const TYPE_AMOUNT = 'amount';
    const TYPE_DICIMAL = 'dicimal';
    
    protected $fillable = [
        'product_id','discount_type','reduction','start_date','expiration_date'
    ];

    public $timestamps = false;




}
