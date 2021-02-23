<?php

namespace App\Http\Resources;

use App\Category;
use App\Product;
use App\ProductImage;
use App\SpecificPrice;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use stdClass;
use DateTime;

class ProductCollection extends ResourceCollection
{

    
    private $idArray = [];
    private $initColumn = ['name','sku','lowest_price','price','stock'];
    private $firstImageDict = null;
    private $firstSpecificPriceDict = null;
    private $catIdDict = null;
    
    public function __construct($resource){
        parent::__construct($resource);
        foreach($this as $model){ $this->idArray[] = $model->id; }
    }

    public function withFirstImage(){
        $this->firstImageDict = [];
        $images = ProductImage::whereIn('product_id',$this->idArray)->orderBy('id','desc')->get();
        foreach ($images as $image) {
            $this->firstImageDict[$image->product_id] = $image->getStaticUrl();    
        }
        return $this;
    }

    public function withFirstSpecificPrice(){
        $this->firstSpecificPriceDict = [];
        $today = new DateTime();
        $specificPrices = SpecificPrice::whereIn('product_id',$this->idArray)
        ->whereDate('expiration_date', '>', $today->format('Y-m-d'))->orderBy('id','desc')->get();
        foreach ($specificPrices as $specificPrice) {
            $this->firstSpecificPriceDict[$specificPrice->product_id] = $specificPrice;
        }
        return $this;
    }
    
    public function withCategoryArray(){
        
        foreach ($this as $product){
            $catId = $product->categories()->pluck('category_id');
            $this->catIdDict[$product->id] = $catId;
        }
        return $this;
        // foreach ($categories as $category){
        //     $this->categoryNameDict[$category->id] = $categor
        // } 
    }
    

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = null)
    {
        return $this->collection->map(function($model) use($request){
            $resource = new stdClass();
            foreach ($this->initColumn as $column) {
                $resource->{$column} = $model->{$column};
            }

            if(!is_null($this->firstImageDict)){
                $imageUrl = $model->getDefaultImageUrl();
                if(isset($this->firstImageDict[$model->id])){
                    $imageUrl = $this->firstImageDict[$model->id];
                }
                $resource->imageUrl = $imageUrl;
            }

            if(!is_null($this->firstSpecificPriceDict)){
                $priceOnSale = null;
                $discount = null;
                if(isset($this->firstSpecificPriceDict[$model->id])){
                    $specificPrice = $this->firstSpecificPriceDict[$model->id];
                    switch ($specificPrice->discount_type) {
                        case SpecificPrice::TYPE_AMOUNT:
                                $priceOnSale = $model->price - $specificPrice->reduction;
                                $discount = '-' . $specificPrice->reduction;
                            break;
                        case SpecificPrice::TYPE_DICIMAL:
                                $priceOnSale = $model->price * $specificPrice->reduction;
                                $discount = '-' . (100 - $specificPrice->reduction * 100) . '%';
                            break;
                        default:
                            break;
                    }
                }
                $resource->priceOnSale = $priceOnSale;
                $resource->discount = $discount;
            }

            if(!is_null($this->catIdDict)){
                $resource->catIdArray = [];
                if(isset($this->catIdDict[$model->id])){
                    $resource->catIdArray = $this->catIdDict[$model->id];
                }
                
            }

            return $resource;
        });
    }
}
