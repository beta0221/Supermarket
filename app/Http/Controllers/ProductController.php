<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;
use App\Rules\SlugRule;
use App\Helpers\StorageHelper;
use App\Helpers\StorageType;
use App\Http\Resources\ProductResouce;
use \Validator;

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
    

    /**取得關聯的 Attribute */
    public function getAttributes($id){
        $product = Product::find($id);
        $attributes = $product->attributes()->get();
        return response($attributes);
    }

    /**更新關聯的 Attribute */
    public function syncAttributes(Request $request,$id){
        $product = Product::find($id);
        $product->attributes()->sync($request->syncArray);
        $attributes = $product->attributes()->get();
        return response($attributes);
    }

    /**取得關聯的 Categories */
    public function getCategories($id){
        $product = Product::find($id);
        $categories = $product->categories()->get();
        return response($categories);
    }

    /**更新關聯的 Categories */
    public function syncCategories(Request $request,$id){
        $product = Product::find($id);
        $product->categories()->sync($request->syncArray);
        $categories = $product->categories()->get();
        return response($categories);
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

    /**取得所有特價 SpecificPrice */
    public function getSpecificPrices($sku){
        $product = Product::where('sku',$sku)->firstOrFail();
        $specificPrices = $product->specificPrices()->get();
        return response($specificPrices);
    }
    
    /**新增特價 SpecificPrice */
    public function addSpecificPrice(Request $request,$sku){
        $validator = Validator::make($request->all(), [
            'discount_type'=>'required|in:amount,dicimal',
            'reduction'=>'required',
            'start_date'=>'required',
            'expiration_date'=>'required',
        ]);
        if ($validator->fails()) { return response($validator->messages(),400); }

        $product = Product::where('sku',$sku)->firstOrFail();
        $specificPrice = $product->specificPrices()->create($request->all());

        return response($specificPrice);
    }

    public function viewProductDetail($sku){

        $product = Product::where('sku',$sku)->firstOrFail();
        $imageList= $product->imagesUrl();
        $specificPrice = $product->getFirstSpecificPrice();

        $product = new ProductResouce($product);
        $product->setSpecificPrice($specificPrice);

        return response([
            'product' => $product,
            'imageList' => $imageList,
        ]);
    }


}
