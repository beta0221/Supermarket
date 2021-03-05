<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartRuleLog extends Model
{
    protected $fillable = [
        'order_id',
        'name',
        'code',
        'start_date',
        'expiration_date',
        'minimum_total',
        'minimum_amount',
        'free_delivery',
        'total_available',
        'total_available_each_user',
        'promo_label',
        'promo_text',
        'multiply_gift',
        'min_nr_products',
        'discount_type',
        'reduction_amount',
        'gift_product_id'
    ];

    public function order(){
      return $this->belongsTo('App\Order','order_id');
    }

    public static function insert_row($order_id,CartRule $rule){
        $cartRuleLog =  new CartRuleLog();      
        $cartRuleLog->order_id = $order_id;
        $cartRuleLog->name = $rule->name;
        $cartRuleLog->code = $rule->code;
        $cartRuleLog->start_date = $rule->start_date;
        $cartRuleLog->expiration_date = $rule->expiration_date;
        $cartRuleLog->minimum_total = $rule->minimum_total;
        $cartRuleLog->minimum_amount = $rule->minimum_amount;
        $cartRuleLog->free_delivery = $rule->free_delivery;
        $cartRuleLog->total_available = $rule->total_available;
        $cartRuleLog->total_available_each_user = $rule->total_available_each_user;
        $cartRuleLog->promo_label = $rule->promo_label;
        $cartRuleLog->promo_text = $rule->promo_text;
        $cartRuleLog->multiply_gift = $rule->multiply_gift;
        $cartRuleLog->min_nr_products = $rule->min_nr_products;
        $cartRuleLog->discount_type = $rule->discount_type;
        $cartRuleLog->reduction_amount = $rule->reduction_amount;
        $cartRuleLog->gift_product_id = $rule->gift_product_id;
        $cartRuleLog->save();
    }
}
