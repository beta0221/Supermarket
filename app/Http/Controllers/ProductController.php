<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;
use App\Rules\SlugRule;
use App\Helpers\StorageHelper;
use App\Helpers\StorageType;

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
    

    /**取得商品圖片 */
    public function getImages($sku){
        $product = Product::where('sku',$sku)->firstOrFail();
        $imagesUrl = $product->imagesUrl();
        return response($imagesUrl);
    }
    
    /**上傳圖片 */
    public function addImage(Request $request,$sku){
        
        if (!$request->has('file')) { return response('Error',400); }
        $product = Product::where('sku',$sku)->firstOrFail();


        if(!$path = StorageHelper::path(StorageType::TYPE_PRODUCT,$product->sku)->store($request->file('file'))){
            return response('Error',500);
        }
                
        $product->images()->create(['name'=>$path]);

        $imageUrl = config('app.static_host') . '/' . $path;
        return response($imageUrl);
    }
    
    /**刪除圖片 */
    public function deleteImage(Request $request,$sku){
        
        if (!$request->has('id')) { return response('Error',400); }
        $product = Product::where('sku',$sku)->firstOrFail();
        
        $image = $product->images()->find($request->id);

        $storageHelper = new StorageHelper();
        $storageHelper->delete($image->name);

        $image->forceDelete();
        
        return response($image);

    }


}
