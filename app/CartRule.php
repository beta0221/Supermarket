<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CartRule extends Model
{

    const RULE_CHANGE_PRICE = 'change_price';
    const RULE_COUPON_DISCOUNT = 'coupon_discount';
    const RULE_GROUP_DISCOUNT = 'group_discount';
    const RULE_THRESHOLD_DISCOUNT = 'threshold_discount';
    const RULE_DELIVERY_DISCOUNT = 'delivery_discount';

    const COLUMN_CHANGE_PRICE = ['priority','status','minimum_amount','discount_type','reduction_amount'];
    const COLUMN_COUPON_DISCOUNT = ['priority','status','code','discount_type','reduction_amount'];
    const COLUMN_GROUP_DISCOUNT = ['priority','status','discount_type','reduction_amount'];
    const COLUMN_THRESHOLD_DISCOUNT = ['priority','status','minimum_total','discount_type','reduction_amount'];
    const COLUMN_DELIVERY_DISCOUNT = ['priority','status','minimum_total','free_delivery','reduction_amount'];

    public static function getRuleTypes(){
        return [
            ['id'=>static::RULE_CHANGE_PRICE,'name'=>'產品變價'],
            ['id'=>static::RULE_COUPON_DISCOUNT,'name'=>'Coupon碼'],
            ['id'=>static::RULE_GROUP_DISCOUNT,'name'=>'群組折扣'],
            ['id'=>static::RULE_THRESHOLD_DISCOUNT,'name'=>'滿額折扣'],
            ['id'=>static::RULE_DELIVERY_DISCOUNT,'name'=>'免運折扣'],
        ];
    }

    public static function getColumnsDict(){
        return [
            static::RULE_CHANGE_PRICE => static::COLUMN_CHANGE_PRICE,
            static::RULE_COUPON_DISCOUNT => static::COLUMN_COUPON_DISCOUNT,
            static::RULE_GROUP_DISCOUNT => static::COLUMN_GROUP_DISCOUNT,
            static::RULE_THRESHOLD_DISCOUNT => static::COLUMN_THRESHOLD_DISCOUNT,
            static::RULE_DELIVERY_DISCOUNT => static::COLUMN_DELIVERY_DISCOUNT
        ];
    }

    const TYPE_AMOUNT = 'amount';
    const TYPE_DICIMAL = 'dicimal';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'rule_type',
        'code',
        'priority',
        'start_date',
        'expiration_date',
        'status',
        'highlight',
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

    public static function get_fillable(){
        $cartRule = new CartRule();
        return $cartRule->fillable;
    }

    public function categories(){
        return $this->belongsToMany('App\Category','cart_rule_categories','cart_rule_id','category_id');
    }

    public function productGroups(){
        return $this->belongsToMany('App\ProductGroup','cart_rule_product_groups','cart_rule_id','product_group_id');
    }

    /**搜尋Coupon類型 */
    public static function getCouponDiscountRule($code){
        $cartRule = CartRule::where('rule_type',CartRule::RULE_COUPON_DISCOUNT)
            ->where('status',1)
            ->where('code',$code)
            ->orderBy('priority','desc')
            ->first();
        return $cartRule;
    }

    /**搜尋免運類型 */
    public static function getDeliveryDiscountRule($total){
        $cartRule = CartRule::where('rule_type',static::RULE_DELIVERY_DISCOUNT)
            ->where('status',1)
            ->where('minimum_total','<=',$total)
            ->orderBy('priority','desc')
            ->first();
        return $cartRule;
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

    // public static function getCartRuleByCategoryIdArray($category_id){
    //     $cartRuleIdArray = DB::table('cart_rule_categories')->where('category_id',$category_id)->pluck('cart_rule_id');
    //     $cartRule = CartRule::whereIn('id',$cartRuleIdArray)->where('status',1)->orderBy('priority','desc')->first();
    //     return $cartRule;
    // }
    public static function getCartRuleByProductGroupId($product_group_id){
        $cartRuleIdArray = DB::table('cart_rule_product_groups')->where('product_group_id',$product_group_id)->pluck('cart_rule_id');
        $cartRule = CartRule::whereIn('id',$cartRuleIdArray)->where('status',1)->orderBy('priority','desc')->first();
        return $cartRule;
    }

    public static function checkCoupon($code){ //檢查coupon 正不正確
        $date = date('Y-m-d');
        $coupon = CartRule::where('code',$code)
             ->where('status',1)
             ->whereDate('start_date', '<=',$date)
             ->whereDate('expiration_date', '>',$date)
             ->count();
             
             return $coupon;
    }

}
