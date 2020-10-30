<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;
use App\Rules\SlugRule;

class ProductController extends Controller
{

    use CrudTrait;

    public function __construct(){
        
        
        $this->model = Product::class;
        $rule = [
            'group_id'=>['required','integer'],
            'attribute_set_id'=>['required','integer'],
            'name'=>['required','max:255','string'],
            'description'=>['required'],
            'price'=>['required'],
            'sku'=>['required','unique:products','max:255','string', new SlugRule],
            'stock' => ['required','integer'],
            'active' => ['required','integer'],
        ];
        $this->storeRule = $rule;
        $this->updateRule = $rule;
        $this->updateColumns = ['group_id','attribute_set_id','name','description','price','stock','active'];
    }
    
    public function test(){
        $product = Product::find(1);
        $group = $product->attributeSet->name;
        return response($group);
    }
    
    
}
