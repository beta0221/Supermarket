<?php
namespace App\Helpers;

use App\CartRule;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartHandler{

    /**小記 */
    private $subtotal = 0;
    /**運費 */
    private $shipping_fee = 0;
    /**手續費 */
    private $transfer_fee = 0;
    /**折扣 */
    private $discount = 0;
    /**總額 */
    private $total = 0;

    /**購物車中的物品 */
    private $cartItems;
    /**購物車規則 */
    private $cartRules = [];
    private $cartRulesDict = [];

    public function __construct(){
        $this->cartItems = Cart::content();
        $this->getValidCartRules();
    }

    /**取出所有符合條件的CartRule */
    private function getValidCartRules(){
        //by Category
        $categoryIdArray = $this->getCategoryIdArray();
        $cartRuleList = CartRule::getCartRulesByCategoryIdArray($categoryIdArray);
        $this->setCartRules($cartRuleList);
        //by Coupon Code
        
    }

    /**
     * 把CartRuleList放進 $this->cartRules (不重複)
     * @param array $cartRuleList
     */
    private function setCartRules($cartRuleList){
        foreach ($cartRuleList as $cartRule) {
            if(isset($this->cartRulesDict[$cartRule->id])){continue;}
            $this->cartRules[] = $cartRule;
            $this->cartRulesDict[$cartRule->id] = true;
        }
    }

    /**
     * 取得購物車中所有Category 的 id 
     * @return array
     * */
    private function getCategoryIdArray(){
        $categoryIdArray = [];
        foreach ($this->cartItems as $item) {
            $categoryList = $item->model->categories()->get();
            foreach ($categoryList as $category) {
                if(!in_array($category->id,$categoryIdArray)){
                    $categoryIdArray[] = $category->id;
                }
            }
        }
        return $categoryIdArray;
    }


}