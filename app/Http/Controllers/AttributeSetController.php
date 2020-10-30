<?php

namespace App\Http\Controllers;

use App\AttributeSet;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;

class AttributeSetController extends Controller
{
    use CrudTrait;

    public function __construct(){
        
        $this->model = AttributeSet::class;
        $rule = ['name'=>['required','max:255','string'],];
        $this->storeRule = $rule;
        $this->updateRule = $rule;
        $this->updateColumns = ['name'];
    }


    /**取得所有 AttrubuteSet */
    public function all(){
        return response(AttributeSet::all());
    }

    /**取得關聯的 Attribute */
    public function getAttributes($id){
        $attributeSet = AttributeSet::find($id);
        $attributes = $attributeSet->attributes()->get();
        return response($attributes);
    }

    /**更新關聯的 Attribute */
    public function syncAttributes(Request $request,$id){
        $attributeSet = AttributeSet::find($id);
        $attributeSet->attributes()->sync($request->syncArray);
        $attributes = $attributeSet->attributes()->get();
        return response($attributes);
    }

    /**取得關聯的 Product */
    public function getProducts($id){
        $attributeSet = AttributeSet::find($id);
        $products = $attributeSet->products()->get();
        return response($products);
    }
}
