<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    use CrudTrait;

    public function __construct(){
        $this->model = Payment::class;
        $this->storeRule = [
            'name'=>['required'],
        ];
        $this->updateRule = [
            'name'=>['required'],
        ];
        $this->updateColumns = ['name'];
    }

    /**取得所有 Payment */
    public function all(){
        return response(Payment::all());
    }

    /** 綠界付款完成頁面  */
    public function view_ecpay_thankyouPage($order_numero){
        return redirect()->route('thankyou',['order_numero'=>$order_numero]);
    }

    /** 付款完成api */
    public function api_ecpay_pay(Request $request,$order_numero){

        Log::info("accept ecpay api");
        Log::info("order_numero:".$order_numero);
        $body = json_decode($request->getContent(),true);
        Log::info($body);

        return "1|OK";
    }




}
