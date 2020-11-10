<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class CartProductResource extends JsonResource
{

    private $initColumn = ['name','price','stock'];
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request=null)
    {
        
        $resource = new stdClass();
        foreach ($this->initColumn as $column) {
            $resource->{$column} = $this->{$column};
        }

        $resource->imageUrl = $this->getFirstImageUrl();
        $resource->priceOnSale = $this->getPriceOnSale();
        
        return $resource;

    }
}
