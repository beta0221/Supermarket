<?php

namespace App\Http\Controllers;

use App\Address;
use App\CartRule;
use App\CartRuleLog;
use App\Helpers\CartHandler;
use Illuminate\Http\Request;
use App\Product;
use App\Order;
use App\OrderProduct;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Resources\CartCollection;
use App\Jobs\SendOrderInfoMail;
use App\Payment;
use \Validator;
use TsaiYiHua\ECPay\Checkout;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{


    private $checkout;

    public function __construct(Checkout $checkout)
    {
        $this->checkout = $checkout;
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
        Cart::add($product,$request->qty);
        return response('success');
    }
    /**更新購物車商品數量 */
    public function update(Request $request){

        $request->session()->forget(['bonus_cost','coupon_code']);
        if($user = $request->user()){   //有登入
            if($request->filled('bonus_cost')){    //有使用
                if($user->bonus >= $request->bonus_cost){   //紅利點數夠不夠
                    $request->session()->put('bonus_cost',$request->bonus_cost);
                }else{
                    $request->session()->put('bonus_cost',$user->bonus);
                }
            }
        }
        if($request->filled('coupon_code')){ //有使用
            $request->session()->put('coupon_code',$request->coupon_code);
            if($coupon = CartRule::checkCoupon($request->coupon_code)){
                Session::flash('success', '成功使用折扣碼'); 
            }else{
                Session::flash('error', '折扣碼無效'); 
            }
        }

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
        
        $cartHandler = new CartHandler();
        $address = Address::insert_row($request);
        $order = Order::insert_row($request,$address->id,$cartHandler);
        $order_numero = $order->order_numero;

        // $itemsForECPay=[];
        if(empty($cartHandler->finalCartItems)){ return redirect()->route('shop'); }
        foreach ($cartHandler->finalCartItems as $item){
            OrderProduct::insert_row($order->id,$item);
            // $itemsForECPay[] = [
            //     'name' => $item->name,
            //     'qty' => $item->qty,
            //     'unit' => '個',
            //     'price' => $item->price,
            // ];
        };

        foreach ($cartHandler->cartRules as $rule){
            CartRuleLog::insert_row($order->id,$rule);
        }

        if($user = $request->user()){
            if($cartHandler->bonus_cost){
                $user->updateBonus($cartHandler->bonus_cost);
            }
        }
        
        Cart::destroy();
        $request->session()->forget('bonus_cost');

        $paymentString = Payment::getPaymentString($request->payment_id);
        // $formData = [
        //     'OrderId'=>$order_numero,
        //     //'UserId' => 1, // 用戶ID , Optional
        //     'ItemDescription' => '產品簡介',
        //     'Items' => $itemsForECPay,
        //     'TotalAmount' => $order->total,
        //     'PaymentMethod' => $paymentString, // ALL, Credit, ATM, WebATM
        // ];

        //dispatch send mail queue here
        
        SendOrderInfoMail::dispatch($request->email,$order_numero);

        switch ($paymentString) {
            case Payment::PAYMENT_CREDIT:
            case Payment::PAYMENT_ATM:
                //ecpay 站內付款
                return redirect()->route('payPage',['order_numero'=>$order_numero]);
                //ecpay 跳轉付款
                //return $this->checkout->setReturnUrl(config('app.url') . '/api/thankyou/' . $order_numero)->setPostData($formData)->send();
                break;
            case Payment::PAYMENT_COD:
                $order->setStatus(Order::STATUS_READY);
                return redirect()->route('thankyou',['order_numero'=>$order_numero]);
                break;
            default:
                break;
        }
        return redirect()->route('shop');
    }

    public function test(){
        $cartHandler = new CartHandler();
        return response()->json($cartHandler);
    }
    
}
