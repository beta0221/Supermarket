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
        $this->storeRule = [
            'group_id'=>['required','integer'],
            'attribute_set_id'=>['required','integer'],
            'name'=>['required','max:255','string'],
            'description'=>['required'],
            'price'=>['required'],
            'sku'=>['required','unique:products','max:255','string', new SlugRule],
            'stock' => ['required','integer'],
            'active' => ['required','integer'],
        ];
        $this->updateRule = [
            'group_id'=>['required','integer'],
            'attribute_set_id'=>['required','integer'],
            'name'=>['required','max:255','string'],
            'description'=>['required'],
            'price'=>['required'],
            'stock' => ['required','integer'],
            'active' => ['required','integer'],
        ];
        $this->updateColumns = ['group_id','attribute_set_id','name','description','price','stock','active'];
    }
    

    
    /**上傳圖片 */
    public function addImage(Request $request,$sku){
        
        if (!$request->has('file')) { return response('Error',400); }
        $product = Product::where('sku',$sku)->firstOrFail();


        $product->images()->create(['name'=>'aaa.jpg']);

        return 'hello';
    }
    
    /**刪除圖片 */
    public function deleteImage(Request $request,$sku){

        if (!$request->has('file')) { return response('Error',400); }



    }


}
