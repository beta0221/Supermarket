<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Product;

class CartController extends Controller
{
    public function add($sku){
        $product = Product::where('sku',$sku)->firstOrFail();
        Cart::add($product->id, $product->name, 1, $product->price)->associate('App\Product');
        return response('success');
    }
}
