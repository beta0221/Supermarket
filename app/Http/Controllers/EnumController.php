<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnumController extends Controller
{
    
    public function active_enum(){
        return response([
            [
                'id'=>1,
                'name'=>'上架'
            ],
            [
                'id'=>0,
                'name'=>'下架'
            ]
        ]);
    }

    public function cartRule_status_enum(){
        return response([
            [
                'id'=>1,
                'name'=>'啟用中'
            ],
            [
                'id'=>0,
                'name'=>'關閉中'
            ]
        ]);
    }

    public function cartRule_heightlight_enum(){
        return response([
            [
                'id'=>1,
                'name'=>'開啟'
            ],
            [
                'id'=>0,
                'name'=>'關閉'
            ]
        ]);
    }

    public function cartRule_freeDelivery_enum(){
        return response([
            [
                'id'=>1,
                'name'=>'是'
            ],
            [
                'id'=>0,
                'name'=>'否'
            ]
        ]);
    }


    public function discountType_enum(){
        return response([
            [
                'id'=>'amount',
                'name'=>'定額'
            ],
            [
                'id'=>'dicimal',
                'name'=>'折數'
            ]
        ]);
    }


}
