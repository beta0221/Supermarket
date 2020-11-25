<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MyOrderListCollection extends ResourceCollection
{
    private $statusArray = [
        '0'=>'代付款',
        '1'=>'待出貨',
        '2'=>'準備中',
        '3'=>'已出貨',
        '4'=>'已到貨',
        '5'=>'結案',
        '6'=>'作廢'
    ];
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function getStatusWord(){
        foreach($this as $order){
            $order->status_word = $this->statusArray[$order->status_id];
        }
        return $this;
    }

    public function toArray($request)
    {
        
    }
}
