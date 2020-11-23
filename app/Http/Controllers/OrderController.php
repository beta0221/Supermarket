<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderProductCollection;
use App\Order;
use App\Helpers\Pagination;
use App\OrderProduct;
use App\Product;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    
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

    public function getOrderDetail($order_numero){
        $order = Order::where('order_numero',$order_numero)->firstOrFail();     
        $orderProduct = $order->orderProducts()->get();
        $orderProductCollection = new OrderProductCollection($orderProduct);
        $total = $order->total;
        $orderProduct = $orderProductCollection->withFirstImage()->toArray();
        return response([
            'orderProduct' => $orderProduct,
            'total' => $total,
        ]);
    }
        
}