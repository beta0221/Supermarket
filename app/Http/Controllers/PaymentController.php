<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;

class PaymentController extends Controller
{
    use CrudTrait;

    public function __construct(){
        $this->model = Payment::class;
        $this->storeRule = [
            'name'=>['required'],
        ];
        $this->updateRule = [
            'name'=>['required'],
        ];
        $this->updateColumns = ['name'];
    }

    /**取得所有 Payment */
    public function all(){
        return response(Payment::all());
    }
}
