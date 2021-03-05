<?php
namespace App\Helpers;

use App\CartRule;
use App\Category;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;

class CartHandler{

    /**小記 */
    public $subtotal = 0;
    /**運費 */
    public $delivery_fee = 150;
    /**手續費 */
    public $transfer_fee = 0;
    /**折扣 */
    public $discount = 0;
    /**使用紅利 */
    public $bonus_cost = 0;
    /**使用折扣碼 */
    public $coupon_code = null;
    /**總額 */
    public $total = 0;

    /**購物車中的物品 */
    public $cartItems;
    /**經過計算折扣的物品 */
    public $finalCartItems = [];
    /**購物車規則 */
    public $cartRules = [];
    private $cartRulesDict = [];
    /**判斷 dicimal */
    private $dicimal = false;

    public function __construct(){
        $this->cartItems = Cart::content();

        if($bonus_cost = Session::get('bonus_cost')){
            $this->bonus_cost = $bonus_cost - ($bonus_cost % 50);
            $this->discount = floor($bonus_cost / 50);
        }
        if($coupon_code = Session::get('coupon_code')){
            $this->coupon_code = $coupon_code;
        }

        $this->caculate();
    }

    /**計算總額 */
    private function caculate(){

        foreach ($this->cartItems as $cartItem) {
            $cartRule = CartRule::getCartRuleByProductId($cartItem->model->id,$cartItem->qty);
            if($cartRule){ $this->logCartRules($cartRule); }
            $finalCartItem = FinalCartItem::getInstance($cartItem,$cartRule);
            $this->subtotal += $finalCartItem->subtotal;
            $this->finalCartItems[] = $finalCartItem;
        }
        //先判斷coupon 折扣
        if(isset($this->coupon_code)){     
            if($cartRule = CartRule::where('code',$this->coupon_code)->first()){
                $price = $this->subtotal;
                $this->handleCoupon($price,$cartRule);
            }
        }
        //在判斷group折扣
        foreach ($this->finalCartItems as $cartItem) {
            if(!$productGroup = $cartItem->product->group()->first()){ continue; }
            if($cartRule = CartRule::getCartRuleByProductGroupId($productGroup->id)){
                $this->handleCartItem($cartItem,$cartRule);
            }
        }


        $this->caculateDeliveryFee();
        $this->caculateTotal();
    }

    private function caculateDeliveryFee(){
        if($cartRule = CartRule::getCartRuleByMinimumTotal($this->subtotal)){
            if($cartRule->free_delivery){
                $this->logCartRules($cartRule);
                $this->delivery_fee = 0;
            }
        }
    }

    private function caculateTotal(){
        $this->total = $this->subtotal - $this->discount + $this->delivery_fee + $this->transfer_fee;
    }

    private function handleCartItem($cartItem,CartRule $cartRule){
        $discount = 0;
        $price = $cartItem->price;
        $qty = $cartItem->qty;
        switch ($cartRule->discount_type) {
            case CartRule::TYPE_AMOUNT:
                $discount = $cartRule->reduction_amount*$qty;
                break;
            case CartRule::TYPE_DICIMAL:
                if($this->dicimal === true){return;}
                $discount = intval(strval($price * (1 - $cartRule->reduction_amount)))*$qty;
                break;
            default:
                break;
        }
        $this->discount += $discount;
        $this->logCartRules($cartRule);
    }

    private function handleCoupon($subtotal,CartRule $cartRule){
        $discount = 0;
        switch ($cartRule->discount_type) {
            case CartRule::TYPE_AMOUNT:
                $discount = $cartRule->reduction_amount;
                break;
            case CartRule::TYPE_DICIMAL:
                $discount = intval(strval($subtotal * (1 - $cartRule->reduction_amount)));
                $this->dicimal = true;
                break;
            default:
                break;
        }
        $this->discount += $discount;
        $this->logCartRules($cartRule);
    }

    /**
     * 把CartRuleList放進 $this->cartRules (不重複)
     * @param array $cartRuleList
     */
    private function logCartRules(CartRule $cartRule){
        if(isset($this->cartRulesDict[$cartRule->id])){ return; }
        $this->cartRules[] = $cartRule;
        $this->cartRulesDict[$cartRule->id] = true;
    }


}