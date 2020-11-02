<?php

namespace App\Http\Resources;

use App\SpecificPrice;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResouce extends JsonResource
{
    private $specficPrice;

    /**
     * @param SpecificPrie $specficPrice
     * @return Void
     */
    public function setSpecificPrice(SpecificPrice $specficPrice){
        $this->specficPrice = $specficPrice;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $priceOnSale = null;
        if($this->specficPrice){
            switch ($this->specficPrice->discount_type) {
                case SpecificPrice::TYPE_AMOUNT:
                        $priceOnSale = $this->price - $this->specficPrice->reduction;
                    break;
                case SpecificPrice::TYPE_DICIMAL:
                        $priceOnSale = $this->price * $this->specficPrice->reduction;
                    break;
                default:
                    break;
            }
        }


        return [
            'name'=>$this->name,
            'description'=>$this->description,
            'stock'=>$this->stock,
            'price'=>(int)$this->price,
            'priceOnSale'=>$priceOnSale,
        ];
    }
}
