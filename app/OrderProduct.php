<?php

namespace App;

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
}
