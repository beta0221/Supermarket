<?php

namespace App\Http\Controllers;

use App\Carrier;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;

class CarrierController extends Controller
{
    use CrudTrait;
    public function __construct(){
        $this->model = Carrier::class;
        $this->storeRule = [
            'name'=>['required'],
            'price'=>['required'],
        ];
        $this->updateRule = [
            'name'=>['required'],
            'price'=>['required'],
        ];
        $this->updateColumns = ['name','price','delivery_text'];
    }


    /**取得所有 Carrier */
    public function all(){
        return response(Carrier::all());
    }


}
