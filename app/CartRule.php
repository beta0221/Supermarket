<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CartRule extends Model
{
    const TYPE_AMOUNT = 'amount';
    const TYPE_DICIMAL = 'dicimal';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'priority',
        'start_date',
        'expiration_date',
        'status',
        'highlight',
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

    public static function get_fillable(){
        $cartRule = new CartRule();
        return $cartRule->fillable;
    }

    public function categories(){
        return $this->belongsToMany('App\Category','cart_rule_categories','cart_rule_id','category_id');
    }

    public static function getCartRuleByProductId($product_id,$qty){
        $cartRuleIdArray = DB::table('cart_rule_products')->where('product_id',$product_id)->pluck('cart_rule_id');
        $cartRule = CartRule::whereIn('id',$cartRuleIdArray)
            ->where('status',1)
            ->where('minimum_amount','<=',$qty)
            ->orderBy('priority','desc')
            ->first();
        return $cartRule;
    }

    public static function getCartRuleByCategoryIdArray($categoryIdArray){
        $cartRuleIdArray = DB::table('cart_rule_categories')->whereIn('category_id',$categoryIdArray)->pluck('cart_rule_id');
        $cartRule = CartRule::whereIn('id',$cartRuleIdArray)->where('status',1)->orderBy('priority','desc')->first();
        return $cartRule;
    }

}
