<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use stdClass;

class CartCollection extends ResourceCollection
{

    private $initColumn = ['name','price','qty'];
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = null)
    {
        return $this->collection->map(function($item) use($request){
            
            $resource = new stdClass();
            foreach ($this->initColumn as $column) {
                $resource->{$column} = $item->{$column};
            }

            $resource->model = new CartProductResource($item->model);;

            return $resource;
        });
    }
}
