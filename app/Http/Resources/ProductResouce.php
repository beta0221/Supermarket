<?php

namespace App\Http\Resources;

use App\SpecificPrice;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class ProductResouce extends JsonResource
{

    private $initColumn = ['name','sku','description','price','stock'];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = null)
    {
        $productDetail = new stdClass();
        
        foreach ($this->initColumn as $column) {
            $productDetail->{$column} = $this->{$column};
        }


        $productDetail->priceOnsale =$this->getPriceOnSale();
        
        return $productDetail;
    }
}
