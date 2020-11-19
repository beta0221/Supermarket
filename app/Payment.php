<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    /**
     * 取得所有以物流方式分類的金流方式
     */
    public static function all_sortByCarrier(){
        $carriers = Carrier::all();
        $payments = [];
        foreach ($carriers as $carrier) {
            $payments[$carrier->id] = $carrier->payments()->get();
        }
        return $payments;
    }
}
