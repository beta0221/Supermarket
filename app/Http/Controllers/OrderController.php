<?php

namespace App\Http\Controllers;

use App\Address;
use App\CartRuleLog;
use App\Exports\ExcelAccounting;
use App\Exports\ExcelDelivery;
use App\Http\Resources\OrderProductCollection;
use App\Order;
use App\Helpers\Pagination;
use App\Http\Resources\MyOrderListCollection;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    
    /**後台訂單管理 */
    public function getOrderList(Request $request)
    {  
        $p = new Pagination($request);
        $query = new Order();
        if($request->has('column') && $request->has('value')){
            if($request->column == 'created_at'){
                $query =$query->whereDate($request->column,date('Y-m-d',strtotime($request->value)));
            }
            else if($request->column == 'buyer'){
                $user_id_array = User::where('name','like','%'.$request->value.'%')->pluck('id');
                $query = $query->whereIn('user_id',$user_id_array);
            }
            else{
                $query = $query->where($request->column,'like','%'.$request->value.'%'); 
            }
        }    
        
        $p->cacuTotalPage($query->count()); 

        $orderList = $query->skip($p->skip)
            ->take($p->rows)
            ->orderBy($p->orderBy,$p->order)
            ->get();
        $orderCollection = new OrderCollection($orderList);
        
        return response([
            'data'=>$orderCollection->withUserName(),
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
        
        $order = Order::where('order_numero',$order_numero)->firstOrFail();     
        if(!$this->isUserPermittedToView($order)){ return redirect()->route('shop'); }

        return view('pages.thankyou',[
            'order_numero'=>$order_numero,
        ]);
    }

    public function view_orderDetail($order_numero){
        
        $order = Order::where('order_numero',$order_numero)->firstOrFail();     
        if(!$this->isUserPermittedToView($order)){ return redirect()->route('shop'); }
        
        $orderResource = new OrderResource($order);
        //return response($orderResource);
        return view('pages.orderDetail',[
            'OR'=>$orderResource->toArray(),
        ]);
    }

    /**
     * 檢查使用者能不能觀看訂單內容
     * @param Order $order
     * @return boolean
     */
    private function isUserPermittedToView(Order $order){
        if($user = auth()->user()){
            if($order->user_id != $user->id){ return false; }
        }else{
            if(!is_null($order->user_id)){ return false; }
        }
        return true;
    }

    public function getOrderDetail($order_numero){
        $order = Order::where('order_numero',$order_numero)->firstOrFail();
        $addressInfo = Address::where('id',$order->shipping_address_id)->firstOrFail();
        $userInfo = User::where('id',$order->user_id)->firstOrFail();
        $orderProduct = $order->orderProducts()->get();
        $orderProductCollection = new OrderProductCollection($orderProduct);
        $total = $order->total;
        $orderProduct = $orderProductCollection->withFirstImage();
        $cartRuleList = CartRuleLog::where('order_id',$order->id)->get();
        return response([
            "order" => $order,
            'userInfo' => $userInfo,
            'addressInfo' => $addressInfo,
            'orderProduct' => $orderProduct,
            'total' => $total,
            'cartRuleList'=>$cartRuleList,
        ]);
    }

    public function view_myOrder(Request $request){
        
        $user = auth()->user(); //沒登入會出錯 
        $p = new Pagination($request);

        $query = Order::where('user_id',$user->id);

        $count = $query->count();
        $p->cacuTotalPage($count);
        
        $myOrderList = $query
            ->skip($p->skip)
            ->take($p->rows)
            ->orderBy($p->orderBy,$p->order)
            ->get();
        $myOrderList = new MyOrderListCollection($myOrderList);

        return view('pages.myOrder',[
            'user'=>$user,
            'myOrderList'=>$myOrderList->getStatusWord(),
            'pagination'=>$p
        ]);
    }


    /**
     * 更新訂單狀態到下一個階段（單一訂單號碼）
     */
    public function nextStatus(Request $request){
        $this->validate($request,[
            'order_numero'=>'required',
        ]);     
        $result = Order::updateToNextStatus($request->order_numero);
        if($result == 0){
            return response(['s'=>0,'m'=>'系統錯誤']);
        }else if($result == -1){
            return response(['s'=>0,'m'=>'已作廢']);
        }

        return response(['s'=>1,'m'=>'更新成功']);
    }
    public function prevStatus(Request $request){
        $this->validate($request,[
            'order_numero'=>'required',
        ]);     
        $result = Order::updateToPrevStatus($request->order_numero);
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

    public function groupLastStatus(Request $request){
        $this->validate($request,[
            'order_numero_array'=>'required',
        ]);
        $order_numero_array = json_decode($request->order_numero_array,true);
        foreach ($order_numero_array as $order_numero) {
            Order::updateToPrevStatus($order_numero);
        }
        return response('success');
    }

    public function excel_downloadOrderExcel(Request $request){
        $this->validate($request,[
            'order_numero_array'=>'required',
        ]);
        
        $order_numero_array = explode(',',$request->order_numero_array);
        
        
        $orders = Order::whereIn('order_numero',$order_numero_array)->get();
        $cellData = [];
        $cellDict = [
            // 's232323'=>[
            //     'from'=>2,
            //     'to'=>5,
            // ],
        ];
        foreach ($orders as $index => $order) {
            $delivery = null;
            if(!isset($cellDict[$order->order_numero])){
                $cellDict[$order->order_numero] = ['from'=>$index+2];
                $delivery = Address::find($order->shipping_address_id);
            }else{
                $cellDict[$order->order_numero]['to'] = $index+2;
            }
            $data = [
                $order->created_at,
                $order->order_numero,
                $order->name,
                $order->delivery_date,
                $order->total,
            ];
            if($delivery){
                $data[] = $delivery->name;
                $data[] = $delivery->phone;
                $data[] = $delivery->postal_code;
                $data[] = $delivery->county . $delivery->postal_code . $delivery->address1;
            }
            $cellData[] = $data;
        }

        date_default_timezone_set('Asia/Taipei');
        $now = date("Y-m-d");

        return Excel::download(new OrderExport($cellData,$cellDict),'訂單資料-'.$now.'.xlsx');
        
    }

    public function download_excel(Request $request,$type){
        $this->validate($request,[
            'order_numero_array'=>'required',
        ]);
        
        date_default_timezone_set('Asia/Taipei');
        $order_numero_array = explode(',',$request->order_numero_array);
        $orders = Order::whereIn('order_numero',$order_numero_array)->get();

        $excel = null;
        $filename = null;
        switch ($type) {
            case 'Delivery':
                $excel = new ExcelDelivery($orders);
                $filename = '黑貓出貨-' . date("Y-m-d") . '.csv';
                break;
            case 'Accounting':
                $excel = new ExcelAccounting($orders);
                $filename = '會計帳務-' . date("Y-m-d") . '.csv';
                break;
            default:
                return abort(404);
                break;
        }
        
        return $excel->download($filename,\Maatwebsite\Excel\Excel::CSV);
    }
        
}