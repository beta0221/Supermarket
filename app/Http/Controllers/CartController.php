<?php

namespace App\Http\Controllers;

use App\Address;
use App\Helpers\CartHandler;
use Illuminate\Http\Request;
use App\Product;
use App\Order;
use App\OrderProduct;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Resources\CartCollection;
use \Validator;
use TsaiYiHua\ECPay\Checkout;

class CartController extends Controller
{


    private $checkout;

    public function __construct(Checkout $checkout)
    {
        $this->checkout = $checkout;
        $this->middleware("auth",['only'=>'checkout']);
    }



    /**取得購物車內容 */
    public function getItems(){
        $cartHandler = new CartHandler();
        $cartItems = new CartCollection($cartHandler->finalCartItems);
        return response([
            'items'=>$cartItems,
            'count'=>$cartHandler->cartItems->count(),
            'subtotal'=>$cartHandler->subtotal,
            'total'=>$cartHandler->total,
        ]);
    }
    /**加入購物車 */
    public function add(Request $request, $sku){
        $product = Product::where('sku',$sku)->firstOrFail();
        // Cart::add($product->id, $product->name, $request->qty, $product->getPriceOnSale())->associate('App\Product');
        Cart::add($product,1);
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
            'payment_id'=>'',
            'name'=>'',
            'phone'=>'',
            'country_id'=>'',
            'county'=>'',
            'postal_code'=>'',
            'address1'=>''
        ]);
        return $validator;
    }

    public function validateCheckout(Request $request){

    }

    public function checkout(Request $request){

        $address = Address::insert_row($request);
        $order = Order::insert_row($request,$address->id);
        $carts = Cart::content();
        
        $items=[];
        foreach ($carts as $cart){

            $orderProduct =  new OrderProduct();      
            $orderProduct->name = $cart->name;
            $orderProduct->price = $cart->price;            
            $orderProduct->quantity = $cart->qty;
            $orderProduct->price_with_tax = 0;
            $orderProduct->sku = $cart->model->sku;
            $orderProduct->product_id = $cart->model->id;
            $orderProduct->order_id = $order->id;

            $items[] = [
                'name' => $cart->name,
                'qty' => $cart->qty,
                'unit' => '個',
                'price' => $cart->price,
            ];

            $orderProduct->save();
        };
        Cart::destroy();
        $order_numero = $order->order_numero;

        $formData = [
            'OrderId'=>$order_numero,
            'UserId' => 1, // 用戶ID , Optional
            'ItemDescription' => '產品簡介',
            'Items' => $items,
            'TotalAmount' => $order->total,
            'PaymentMethod' => 'Credit', // ALL, Credit, ATM, WebATM
        ];

        
        return $this->checkout->setPostData($formData)->send();

        return redirect()->route('thankyou',['order_numero'=>$order_numero]);
        
    }

    public function test(){
        $cartHandler = new CartHandler();
        return response()->json($cartHandler);
    }
    
}
