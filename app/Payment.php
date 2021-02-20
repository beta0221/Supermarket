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

    const PAYMENT_CREDIT = 'Credit';
    const PAYMENT_ATM = 'ATM';
    const PAYMENT_COD = 'COD';

    /**
     * 取得payment_id對應的金流代號 
     * @param int $payment_id
     * @return string
     * */
    public static function getPaymentString($payment_id){

        $paymetStringDict = [
            '1'=>static::PAYMENT_CREDIT,
            '2'=>static::PAYMENT_ATM,
            '3'=>static::PAYMENT_COD,
        ];

        if(!isset($paymetStringDict[$payment_id])){
            return null;    
        }
        return $paymetStringDict[$payment_id];
    }

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
