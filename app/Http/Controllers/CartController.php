<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Product;

class CartController extends Controller
{
    /**取得購物車內容 */
    public function api_getCartItems(){
        
    }
    /**加入購物車 */
    public function add($sku){
        $product = Product::where('sku',$sku)->firstOrFail();
        Cart::add($product->id, $product->name, 1, $product->price)->associate('App\Product');
        return response('success');
    }
    /**更新購物車商品數量 */
    public function update(Request $request){
        foreach ($request->rowIdArray as $rowId) {
            $qty_rowId = "qty_$rowId";
            $qty = $request->{$qty_rowId};
            Cart::update($rowId,$qty);
        }
        return redirect()->route('cart');
    }
    /**刪除商品 */
    public function delete($rowId){
        Cart::remove($rowId);
        return response('success');
    }
}
