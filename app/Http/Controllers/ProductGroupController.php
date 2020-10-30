<?php

namespace App\Http\Controllers;

use App\ProductGroup;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;

class ProductGroupController extends Controller
{
    use CrudTrait;

    public function __construct(){
        
        $this->model = ProductGroup::class;
        $rule = ['name'=>['required','max:255','string'],];
        $this->storeRule = $rule;
        $this->updateRule = $rule;
        $this->updateColumns = ['name'];
    }



    /**取得全部 ProductGroup */
    public function all(){
        return response(ProductGroup::all());
    }
    /**取得關聯的 Product */
    public function getProducts($id){
        $productGroup = ProductGroup::find($id);
        $products = $productGroup->products()->get();
        return response($products);
    }
}
