<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Traits\CrudTrait;
use App\Rules\SlugRule;
use App\Helpers\StorageHelper;
use App\Helpers\StorageType;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResouce;
use App\SpecificPrice;
use App\UploadProductDescriptionImageLog;
use \Validator;
use Illuminate\Support\Facades\Session;

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
            'lowest_price'=>['required'],
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
            'lowest_price'=>['required'],
            'price'=>['required'],
            'stock' => ['required','integer'],
            'active' => ['required','integer'],
        ];
        $this->updateColumns = ['group_id','attribute_set_id','name','description','lowest_price','price','bonus_rate','stock','active'];
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

    /**取得關聯得 CartRule */
    public function getCartRules($id){
        $product = Product::find($id);
        $cartRules = $product->cartRules()->get();
        return response($cartRules);
    }
    /**更新關聯的 CartRule */
    public function syncCartRules(Request $request,$id){
        $product = Product::find($id);
        $product->cartRules()->sync($request->syncArray);
        $cartRules = $product->cartRules()->get();
        return response($cartRules);
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

    /**上傳商品說明區的圖片 */
    public function addImageInDescription(Request $request,$sku){
        if (!$request->has('upload')) { return response('Error',400); }
        $product = Product::where('sku',$sku)->firstOrFail();

        if(!$path = StorageHelper::path(StorageType::TYPE_DESCRIPTION,$product->sku)->store($request->file('upload'))){
            return response('Error',500);
        }

        $imageUrl = config('app.static_host') . '/' . $path;
        UploadProductDescriptionImageLog::log($product->sku,$imageUrl,$path);

        return response([
            'url'=>$imageUrl,
        ],200);
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
    /**取得特價中 SpecificPrice */
    public function getSpecificPricesING($sku){
        $product = Product::where('sku',$sku)->firstOrFail();
        $specificPrices = $product->specificPrices();
        
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
    public function deleteSpecifiPrice($id){
       $specificPrice = SpecificPrice::where('id',$id)->firstOrFail();
       $specificPrice->delete();

       return response($specificPrice);
    }

    public function viewProductDetail($sku){

        $product = Product::where('sku',$sku)->firstOrFail();
        $priceList = $product->getPriceList();

        //save session
        if(!session('lastSeen')){
            session()->put('lastSeen', []);
            Session::push('lastSeen',$product);
        }else{
            $lastSeen = Session::get('lastSeen');
            //刪除一樣的商品 並新增到最上面
            if (($key = array_search($product,$lastSeen)) !== false) {
                Session::pull('lastSeen.'.$key);
                Session::push('lastSeen',$product);
            }else{
                Session::push('lastSeen',$product);
            }
        }
        
        $imageList= $product->imagesUrl();
        $product = new ProductResouce($product);
        

        $productCollection = [];
        if($product->categories()->first()){
            $relateToProducts = $product->categories()
            ->firstOrFail()
            ->products()
            ->get();
        $productCollection = new ProductCollection($relateToProducts);
        $productCollection = $productCollection->withFirstImage()->toArray();
        }else{
           
        }
            

        return view('pages.product',[
            'priceList'=>$priceList,
            'product' => $product->toArray(),
            'imageList' => $imageList,
            'relateToProducts' => $productCollection,
            'sku'=>$sku
        ]);
    }


}
