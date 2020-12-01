<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\ProductImage;
use stdClass;
class OrderProductCollection extends ResourceCollection
{
    private $idArray = [];
    private $initColumn = ['name','sku','price','quantity'];
    private $firstImageDict = null;

    public function __construct($resource){
        parent::__construct($resource);
        foreach($this as $model){ $this->idArray[] = $model->product_id; }
    }

    public function withFirstImage(){
        $this->firstImageDict = [];
        $images = ProductImage::whereIn('product_id',$this->idArray)->orderBy('id','desc')->get();
        foreach ($images as $image) {
            $this->firstImageDict[$image->product_id] = $image->getStaticUrl();    
        }
        return $this;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = null)
    {
        // $orderDetail = new stdClass();
        // foreach ($this->initColumn as $column) {
        //     $orderDetail->{$column} = $this->{$column};
        // }
        // $orderDetail->order_numero = $this->order()->order_numero;

        // return $orderDetail;

        return $this->collection->map(function($model) use($request){
            $resource = new stdClass();
            foreach ($this->initColumn as $column) {
                $resource->{$column} = $model->{$column};
            }

            if(!is_null($this->firstImageDict)){
                $imageUrl = $model->getDefaultImageUrl();
                if(isset($this->firstImageDict[$model->product_id])){
                    $imageUrl = $this->firstImageDict[$model->product_id];
                }
                $resource->imageUrl = $imageUrl;
            }

            return $resource;
        });
    }
}
