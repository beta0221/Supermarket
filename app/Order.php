<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_numero',
        'user_id',
        'status_id',
        'carrier_id',
        'shipping_address_id',
        'billing_address_id',
        'billing_company_id',
        'currency_id',
        'comment',
        'shipping_no',
        'invoice_no',
        'invoice_date',
        'delivery_date',
        'total_discount',
        'total_discount_tax',
        'total_shipping',
        'total_shipping_tax',
        'total',
        'total_tax',
    ];

    public static $key = 'order_numero';


    public function orderProducts(){
        return $this->hasMany('App\OrderProduct','order_products','order_id','product_id');
    }
    

}
