<?php
namespace App\Helpers;

use App\CartRule;
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
    /**總額 */
    public $total = 0;

    /**購物車中的物品 */
    public $cartItems;
    /**經過計算折扣的物品 */
    public $finalCartItems = [];
    /**購物車規則 */
    public $cartRules = [];
    private $cartRulesDict = [];

    public function __construct(){
        $this->cartItems = Cart::content();

        if($bonus_cost = Session::get('bonus_cost')){
            $this->bonus_cost = $bonus_cost - ($bonus_cost % 50);
            $this->discount = floor($bonus_cost / 50);
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

        foreach ($this->finalCartItems as $cartItem) {
            $product_group_id = $cartItem->product->group()->first()->id;        
            if($cartRule = CartRule::getCartRuleByProductGroupId($product_group_id)){
                $this->handleCartItem($cartItem,$cartRule);
            }
        }
        $this->caculateDeliveryFee();
        $this->caculateTotal();
    }

    private function caculateDeliveryFee(){
        if($cartRule = CartRule::getCartRuleByMinimumTotal($this->subtotal)){
            if($cartRule->free_delivery){
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
                $discount = intval(strval($price * (1 - $cartRule->reduction_amount)))*$qty;
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
    private function logCartRules($cartRule){
        if(isset($this->cartRulesDict[$cartRule->id])){ return; }
        $this->cartRules[] = $cartRule;
        $this->cartRulesDict[$cartRule->id] = true;
    }


}