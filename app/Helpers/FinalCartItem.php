<?php
namespace App\Helpers;

use App\CartRule;

class FinalCartItem{

    public $rowId;
    public $name;
    public $price;
    public $qty;
    public $subtotal;
    public $product;

    public static function getInstance($cartItem,CartRule $cartRule = null){
        $finalCartItem = new FinalCartItem();
        $finalCartItem->rowId = $cartItem->rowId;
        $finalCartItem->name = $cartItem->name;
        $finalCartItem->price = $cartItem->price;
        if($cartRule){
            $finalCartItem->price = $cartItem->model->cartRulePrice($cartRule);
        }
        $finalCartItem->qty = $cartItem->qty;
        $finalCartItem->subtotal = $finalCartItem->qty * $finalCartItem->price;
        $finalCartItem->product = $cartItem->model;
        return $finalCartItem;
    }

    
}