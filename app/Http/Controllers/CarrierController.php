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

    /** 取得關聯的 Payment */
    public function getPayments($id){
        $carrier = Carrier::find($id);
        $payments = $carrier->payments()->get();
        return response($payments);
    }

    /**更新關聯 */
    public function syncPayments(Request $request,$id){
        $carrier = Carrier::find($id);
        $carrier->payments()->sync($request->syncArray);
        $payments = $carrier->payments()->get();
        return response($payments);
    }

}
