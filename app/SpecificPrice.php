<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecificPrice extends Model
{
    protected $fillable = [
        'product_id','discount_type','reduction','start_date','expiration_date'
    ];

    public $timestamps = false;




}
