<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Cart;

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

    const STATUS_PENDING_PAYMENT = 0;
    const STATUS_READY = 1;
    const STATUS_PREPARE = 2;
    const STATUS_SHIPPING = 3;
    const STATUS_ARRIVE = 4;
    const STATUS_CLOSE = 5;
    const STATUS_INVALID = 6;


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
        $carts_total = Cart::subtotal();
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
        $order->total = $carts_total;
        $order->total_tax = 0;
        $order->save();

        return $order;
    }

    public static function updateToNextStatus($order_numero){
        $first = Order::where('order_numero',$order_numero)->first();
        if(!$first){
            return 0;
        }
        if($first->status_id == Order::STATUS_INVALID){
            return -1;
        }
        $nextStatus = $first->status_id + 1;
        Order::where('order_numero',$order_numero)->update([
            'status_id'=>$nextStatus
        ]);
        return 1;
    }
    

}
