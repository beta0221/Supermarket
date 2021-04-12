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
        $this->storeRule = ['name'=>['required']];
        $this->updateRule = [
            'name'=>['required'],
            'rule_type'=>['required'],
        ];
        $this->updateColumns = CartRule::get_fillable();
    }
    /**取得所有 CartRule */
    public function all(){
        $cartRules = CartRule::where('status',1)->get();
        return response($cartRules);
    }

    /**取得所有 CartRule 的enum 類別 */
    public function all_type(){
        $types = CartRule::getRuleTypes();
        return response($types);
    }

    /**取得所有type 對應的欄位 */
    public function getColumnsDict(){
        $dict = CartRule::getColumnsDict();
        return response($dict);
    }
    
}
