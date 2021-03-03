<?php

namespace App;

use App\Helpers\FinalCartItem;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'product_id',
        'order_id',
        'name',
        'sku',
        'price',
        'price_with_tax',
        'quantity'
    ];
    public $timestamps = false;
    /**關聯 Order */
    public function order(){
        return $this->belongsTo('App\Order','order_id');
    }
    public function getDefaultImageUrl(){
        return config('app.static_host') . '/default_product_image.png';
    }

    /**
     * insert一比資料
     * @param integer $order_id
     * @param FinalCartItem $item
     * @return void
     */
    public static function insert_row($order_id,FinalCartItem $item){
        $orderProduct =  new OrderProduct();      
        $orderProduct->name = $item->name;
        $orderProduct->price = $item->price;     
        $orderProduct->bonus_rate = $item->product->bonus_rate;
        $orderProduct->quantity = $item->qty;
        $orderProduct->price_with_tax = 0;
        $orderProduct->sku = $item->product->sku;
        $orderProduct->product_id = $item->product->id;
        $orderProduct->order_id = $order_id;
        $orderProduct->save();
    }
}
