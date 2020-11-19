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

    /**關聯 Payment */
    public function payments(){
        return $this->belongsToMany('App\Payment','carrier_payment','carrier_id','payment_id');
    }
    
}
