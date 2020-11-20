<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderProductCollection;
use App\Order;
use App\Helpers\Pagination;
use App\OrderProduct;
use App\Product;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;

class OrderController extends Controller
{
    // public function __construct(){


    //     $this->model = Order::class;
    //     $this->storeRule = [
    //         'user_id'=>['required','integer'],
    //         'status_id'=>['required','integer'],
    //         'carrier_id'=>['required','integer'],
    //         'shipping_address_id'=>['required','integer'],
    //         'billing_address_id'=>['required','integer'],
    //         'currency_id'=>['required','integer'],
    //         'comment'=>['required'],
    //         'shipping_no'=>['required','string'],
    //         'invoice_no'=>['required','string'],
    //         'invoice_date'=>['required','date'],
    //         'delivery_date'=>['required','integer'],
    //         'total_discount'=>['required'],
    //         'total_discount_tax'=>['required'],
    //         'total_shipping'=>['required'],
    //         'total_shipping_tax'=>['required'],
    //         'total'=>['required'],
    //         'total_tax'=>['required'],
    //     ];
    //     $this->updateRule = [
    //         'user_id'=>['required','integer'],
    //         'status_id'=>['required','integer'],
    //         'carrier_id'=>['required','integer'],
    //         'shipping_address_id'=>['required','integer'],
    //         'billing_address_id'=>['required','integer'],
    //         'currency_id'=>['required','integer'],
    //         'comment'=>['required'],
    //         'shipping_no'=>['required','string'],
    //         'invoice_no'=>['required','string'],
    //         'invoice_date'=>['required','date'],
    //         'delivery_date'=>['required','integer'],
    //         'total_discount'=>['required'],
    //         'total_discount_tax'=>['required'],
    //         'total_shipping'=>['required'],
    //         'total_shipping_tax'=>['required'],
    //         'total'=>['required'],
    //         'total_tax'=>['required'],
    //     ];
    //     $this->updateColumns = ['user_id','status_id','carrier_id','shipping_address_id','billing_address_id','currency_id','comment',
    //         'shipping_no','invoice_no','invoice_date,','delivery_date','total_discount','total_discount_tax','total_shipping',
    //         'total_shipping_tax','total','total_tax'];

    // }
    public function index(Request $request)
    {  
        $p = new Pagination($request);
        $p->cacuTotalPage(Order::count());
        
        $modelList = Order::skip($p->skip)
            ->take($p->rows)
            ->orderBy($p->orderBy,$p->order)
            ->get();

        return response([
            'data'=>$modelList,
            'pagination'=>$p,
        ]);
    }
    
    /**取得 Products */
    public function getOrderProducts(Request $request,$id){
        $order = Order::find($id);
        $products = $order->orderProducts()->get();
        return response($products);
    }

    public function view_thankyou($order_numero){
        
        $order_numero = $order_numero;


        return view('pages.thankyou',[
            'order_numero'=>$order_numero,
        ]);
    }

    public function view_orderDetail($order_numero){
        
        $order = Order::where('order_numero',$order_numero)->firstOrFail();     
        $orderProduct = $order->orderProducts()->get();
        $orderProductCollection = new OrderProductCollection($orderProduct);
        $total = $order->total;
        return view('pages.orderDetail',[
            'orderProduct' => $orderProductCollection->withFirstImage()->toArray(),
            'order_numero' => $order_numero,
            'total' => $total,
        ]);
    }
        
}