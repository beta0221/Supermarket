<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Resources\CartCollection;

class CartController extends Controller
{
    /**取得購物車內容 */
    public function getItems(){
        $carts = Cart::content();
        $cartItems = new CartCollection($carts);
        return response([
            'items'=>$cartItems,
            'count'=>$carts->count(),
            'total'=>Cart::total(),
        ]);
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
