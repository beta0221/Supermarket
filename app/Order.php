<?php

namespace App;

use App\Helpers\CartHandler;
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
        'bonus_cost',
        'subtotal',
    ];

    public static $key = 'order_numero';

    const STATUS_PENDING_PAYMENT = 0;
    const STATUS_READY = 1;
    const STATUS_PREPARE = 2;
    const STATUS_SHIPPING = 3;
    const STATUS_ARRIVE = 4;
    const STATUS_CLOSE = 5;
    const STATUS_INVALID = 6;

    public static $statusDict = [
        '0'=>'待付款',
        '1'=>'待出貨',
        '2'=>'準備中',
        '3'=>'已出貨',
        '4'=>'已到貨',
        '5'=>'結案',
        '6'=>'作廢'
    ];


    public function orderProducts(){
        return $this->hasMany('App\OrderProduct');
    }
    public function cartRuleLog(){
        return $this->hasMany('App\CartRuleLog');
    }

    /**
     * 存資料到資料表 Order
     * @param Request $request
     * @param int $address_id
     * @return Order
     */
    public static function insert_row(Request $request,int $address_id,CartHandler $cartHandler){
        $order = new Order();
        $order->order_numero = uniqid();
        if($user = $request->user()){
            $order->user_id = $user->id;
        }
        $order->carrier_id = $request->carrier_id;
        $order->payment_id = $request->payment_id;

        $order->shipping_address_id = $address_id;
        $order->billing_address_id = $address_id;

        $order->currency_id = 1;
        $order->comment = $request->comment;

        $order->subtotal = $cartHandler->subtotal;
        $order->bonus_cost = $cartHandler->bonus_cost;
        $order->total_discount = floatval($cartHandler->discount);
        $order->total_discount_tax = 0;
        $order->total_shipping = floatval($cartHandler->delivery_fee);
        $order->total_shipping_tax = 0;
        $order->total = floatval($cartHandler->total);
        $order->total_tax = 0;

        if($request->has('delivery_date')){
            $order->delivery_date = $request->delivery_date;
        }
        if($request->has('delivery_time')){
            $order->delivery_time = $request->delivery_time;
        }

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
    public static function updateToPrevStatus($order_numero){
        $first = Order::where('order_numero',$order_numero)->first();
        if(!$first){
            return 0;
        }
        // if($first->status_id == Order::STATUS_INVALID){
        //     return -1;
        // }
        $lastStatus = $first->status_id - 1;
        Order::where('order_numero',$order_numero)->update([
            'status_id'=>$lastStatus
        ]);
        return 1;
    }

    /**
     * 調整訂單狀態
     * @param int $status
     * @return void
     */
    public function setStatus(int $status){
        if(!isset(Order::$statusDict[$status])){ return; }
        $this->status_id = $status;
        $this->save();
    }

    /**
     * 計算這筆訂單可以獲得多少紅利點數
     * @return int
     */
    public function cacuOrderBonus(){
        $bonus = 0;
        $orderProducts = OrderProduct::where('order_id',$this->id)->get();
        foreach ($orderProducts as $op) {
            $bonus += $op->quantity * $op->price * $op->bonus_rate;
        }   
        return $bonus;
    }

    /**發送此筆訂單應該發的紅利給下單者 */
    public function sendBonusToBuyer(){
        $bonus = $this->cacuOrderBonus();
        if(!$buyer = User::find($this->user_id)){ return; }
        $buyer->updateBonus($bonus,false);
    }
    

}
