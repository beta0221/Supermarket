<?php

namespace App\Http\Resources;

use App\Order;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MyOrderListCollection extends ResourceCollection
{
    
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function getStatusWord(){


        $statusDict = Order::$statusDict;
        foreach($this as $order){
            $order->status_word = $statusDict[$order->status_id];
        }
        return $this;
    }

    public function toArray($request)
    {
        
    }
}
