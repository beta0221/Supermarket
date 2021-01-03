<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Pagination;
use App\User;
use App\Order;
class MemberController extends Controller
{
    //後台用的請求
    public function getMembers(Request $request){
        $p = new Pagination($request);
        $query = new User();
        if($request->has('column') && $request->has('value')){
            if($request->column == 'created_at'){
                $query =$query->whereDate($request->column,date('Y-m-d',strtotime($request->value)));
            }
            else{
                $query = $query->where($request->column,'like','%'.$request->value.'%'); 
            }
               
        }    
        $p->cacuTotalPage($query->count()); 

        $modelList = $query->skip($p->skip)
            ->take($p->rows)
            ->orderBy($p->orderBy,$p->order)
            ->get();

        return response([
            'data'=>$modelList,
            'pagination'=>$p,
        ]);
    }
    
    public function userOrderList(Request $request,$id){
        $p = new Pagination($request);
        $p->cacuTotalPage(Order::where('user_id',$id)->count());
        
        $modelList = Order::where('user_id',$id)
            ->skip($p->skip)
            ->take($p->rows)
            ->orderBy($p->orderBy,$p->order)
            ->get();

        // $userOrder = Order::where('user_id',$id);
        return response([
            'data'=>$modelList,
            'pagination'=>$p,
        ]);
    }
}
