<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Pagination;
use App\User;

class MemberController extends Controller
{
    //後台用的請求
    public function getMembers(Request $request){
        $p = new Pagination($request);
        $p->cacuTotalPage(User::count());
        
        $modelList = User::skip($p->skip)
            ->take($p->rows)
            ->orderBy($p->orderBy,$p->order)
            ->get();

        return response([
            'data'=>$modelList,
            'pagination'=>$p,
        ]);
    }
}
