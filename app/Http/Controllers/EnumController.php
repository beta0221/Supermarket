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
}
