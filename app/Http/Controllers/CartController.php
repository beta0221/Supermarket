<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Order;
use App\OrderProduct;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Resources\CartCollection;
use \Validator;

class CartController extends Controller
{
    /**取得購物車內容 */
    public function getItems(){
        $carts = Cart::content();
        $cartItems = new CartCollection($carts);
        return response([
            'items'=>$cartItems,
            'count'=>$carts->count(),
            'total'=>Cart::subtotal(),
        ]);
    }
    /**加入購物車 */
    public function add(Request $request, $sku){
        $product = Product::where('sku',$sku)->firstOrFail();
        Cart::add($product->id, $product->name, $request->qty, $product->price)->associate('App\Product');
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

    private function validateRequest(Request $request){
        $validator = Validator::make($request->all(),[
            'carrier_id'=>'',
            'pay_id'=>'',
        ]);
        return $validator;
    }

    public function validateCheckout(Request $request){

    }

    public function checkout(Request $request){

        // return response(strtotime('Y-m-d'));
        $order = new Order();
        $order->order_numero = uniqid();
        $order->user_id = 1;
        // $order->status_id = '';
        $order->carrier_id = 1;
        $order->shipping_address_id = 1;
        $order->billing_address_id = 1;
        $order->billing_company_id = 1;
        $order->currency_id = 1;
        $order->comment = '';
        $order->shipping_no = '';
        $order->invoice_no = '';
        $order->invoice_date = date('Y-m-d H:i:s');
        $order->delivery_date = date('Y-m-d H:i:s');

        
        $order->total_discount = 0;
        $order->total_discount_tax = 0;
        $order->total_shipping = 0;
        $order->total_shipping_tax = 0;
        $order->total = 100;
        $order->total_tax = 0;
        $order->save();

        

        $carts = Cart::content();
        foreach ($carts as $cart){

            $orderProduct =  new OrderProduct();      
            $orderProduct->name = $cart->name;
            $orderProduct->price = $cart->price;            
            $orderProduct->quantity = $cart->qty;
            $orderProduct->price_with_tax = 0;
            $orderProduct->sku = $cart->model->sku;
            $orderProduct->product_id = $cart->model->id;
            $orderProduct->order_id = $order->id;

            $orderProduct->save();
        };
        Cart::destroy();
        $order_numero = $order->order_numero;
        
        return redirect('/order/thankyou/'.$order_numero);    
    }
    
}
