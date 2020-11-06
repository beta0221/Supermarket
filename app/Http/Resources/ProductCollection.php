<?php

namespace App\Http\Resources;

use App\ProductImage;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use stdClass;

class ProductCollection extends ResourceCollection
{
    private $initColumn = ['name','sku','price','stock'];
    private $firstImageDict = null;
    private $firstSpecificPriceDict = null;

    public function withFirstImage(){
        $this->firstImageDict = [];
        $idArray = [];
        foreach($this as $model){ $idArray[] = $model->id; }
        $images = ProductImage::whereIn('product_id',$idArray)->orderBy('id','desc')->get();
        foreach ($images as $image) {
            $this->firstImageDict[$image->product_id] = $image->getStaticUrl();    
        }
        return $this;
    }
    public function withFirstSpecificPrice(){
        
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
            if($this->firstImageDict){
                $imageUrl = $model->getDefaultImageUrl();
                if(isset($this->firstImageDict[$model->id])){
                    $imageUrl = $this->firstImageDict[$model->id];
                }
                $resource->imageUrl = $imageUrl;
            }
            return $resource;
        });
    }
}
