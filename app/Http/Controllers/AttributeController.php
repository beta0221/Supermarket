<?php

namespace App\Http\Controllers;

use App\Attribute;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;

class AttributeController extends Controller
{
    use CrudTrait;

    public function __construct(){
        
        $this->model = Attribute::class;
        $rule = [
            'type'=>['required','max:255','string'],
            'name'=>['required','max:255','string'],
        ];
        $this->storeRule = $rule;
        $this->updateRule = $rule;
        $this->updateColumns = ['type','name'];
    }

    /**取得所有 Attribute */
    public function all(){
        return response(Attribute::all());
    }

    /** 取得關聯的 AttributeSet */
    public function getAttributeSets($id){
        $attribute = Attribute::find($id);
        $attributeSets = $attribute->attributeSets()->get();
        return response($attributeSets);
    }

    /**更新關聯 */
    public function syncAttributeSets(Request $request,$id){
        $attribute = Attribute::find($id);
        $attribute->attributeSets()->sync($request->syncArray);
        $attributeSets = $attribute->attributeSets()->get();
        return response($attributeSets);
    }

}
