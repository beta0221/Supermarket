<?php
namespace App\Helpers;

use App\CartRule;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartHandler{

    /**小記 */
    public $subtotal = 0;
    /**運費 */
    public $shipping_fee = 0;
    /**手續費 */
    public $transfer_fee = 0;
    /**折扣 */
    public $discount = 0;
    /**總額 */
    public $total = 0;

    /**購物車中的物品 */
    public $cartItems;
    /**購物車規則 */
    public $cartRules = [];
    private $cartRulesDict = [];

    public function __construct(){
        $this->subtotal = Cart::subtotal();
        $this->cartItems = Cart::content();
        $this->caculate();
    }

    /**計算總額 */
    private function caculate(){
        foreach ($this->cartItems as $cartItem) {
            $categoryIdArray = $cartItem->model->categories()->pluck('category_id');
            // echo json_encode($categoryIdArray);
            if($cartRule = CartRule::getCartRuleByCategoryIdArray($categoryIdArray)){
                $this->handleCartItem($cartItem,$cartRule);
            }
        }
    }


    private function handleCartItem($cartItem,CartRule $cartRule){
        $discount = 0;
        $price = $cartItem->price;
        switch ($cartRule->discount_type) {
            case CartRule::TYPE_AMOUNT:
                $discount = $cartRule->reduction_amount;
                break;
            case CartRule::TYPE_DICIMAL:
                $discount = intval(strval($price * $cartRule->reduction_amount));
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