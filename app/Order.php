<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_numero',
        'user_id',
        'status_id',
        'carrier_id',
        'payment_id',
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
        return $this->hasMany('App\OrderProduct');
    }

    /**
     * 存資料到資料表 Order
     * @param Request $request
     * @param int $address_id
     * @return Order
     */
    public static function insert_row(Request $request,int $address_id){
        $order = new Order();
        $order->order_numero = uniqid();
        $order->user_id = $request->user()->id;
        $order->carrier_id = $request->carrier_id;
        $order->payment_id = $request->payment_id;

        $order->shipping_address_id = $address_id;
        $order->billing_address_id = $address_id;

        $order->currency_id = 1;
        $order->comment = $request->comment;

        $order->total_discount = 0;
        $order->total_discount_tax = 0;
        $order->total_shipping = 0;
        $order->total_shipping_tax = 0;
        $order->total = 100;
        $order->total_tax = 0;
        $order->save();

        return $order;
    }
    

}
