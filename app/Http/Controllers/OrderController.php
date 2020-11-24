<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderProductCollection;
use App\Order;
use App\Helpers\Pagination;
use App\OrderProduct;
use App\Product;
use App\User;
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

    public function view_myOrder(Request $request){
        $user = auth()->user(); //沒登入會出錯 
        
        $myOrderList = Order::where('user_id',$user->id)->get();
        // $p = new Pagination($request);
        // $p->cacuTotalPage($order->count());
        
        // $orderList = $order->skip($p->skip)
        //     ->take($p->rows)
        //     ->orderBy($p->orderBy,$p->order)
        //     ->get();

        return view('pages.myOrder',[
            'user'=>$user,
            'myOrderList'=>$myOrderList,
        ]);
    }

    /**
     * 更新訂單狀態到下一個階段（單一訂單號碼）
     */
    public function nextStatus(Request $request){
        $this->validate($request,[
            'order_numero'=>'required',
        ]);
        // $user = request()->user();
        // if(!$user->hasRole('Admin')){
        //     return response('此操作身份必須為"廠商"',403);
        // }ㄌ
        
        $result = Order::updateToNextStatus($request->order_numero);
    
        if($result == 0){
            return response(['s'=>0,'m'=>'系統錯誤']);
        }else if($result == -1){
            return response(['s'=>0,'m'=>'已作廢']);
        }

        return response(['s'=>1,'m'=>'更新成功']);
    }

    /**
     * 更新訂單狀態到下一個階段（批次更新）
     */
    public function groupNextStatus(Request $request){
        $this->validate($request,[
            'order_numero_array'=>'required',
        ]);
        $order_numero_array = json_decode($request->order_numero_array,true);
        foreach ($order_numero_array as $order_numero) {
            Order::updateToNextStatus($order_numero);
        }
        return response('success');
    }
        
}