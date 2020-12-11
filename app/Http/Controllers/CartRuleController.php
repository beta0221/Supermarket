<?php

namespace App\Http\Controllers;

use App\CartRule;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;

class CartRuleController extends Controller
{
    use CrudTrait;

    public function __construct(){
        $this->model = CartRule::class;
        $rule = ['name'=>['required']];
        $this->storeRule = $rule;
        $this->updateRule = $rule;
        $this->updateColumns = CartRule::get_fillable();
    }
    /**取得所有 CartRule */
    public function all(){
        return response(CartRule::all());
    }
    
}
