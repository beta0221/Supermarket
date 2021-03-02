<?php

namespace App\Http\Resources;

use App\Address;
use App\Carrier;
use App\Payment;
use App\User;
use App\Order;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

/**
 * [訂單詳情]orders資料表中，單一個row的資料延伸，包含訂單商品(OrderProductCollection)。
 */
class OrderResource extends JsonResource
{

    private $initColumn = ['order_numero','bonus_cost','total_discount','total_shipping','total','comment','created_at'];
    private $orderResource;
    
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->orderResource = new stdClass();
    }
    
    /**基本的order欄位 */
    private function handleInitColumns(){
        foreach ($this->initColumn as $column) {
            $this->orderResource->{$column} = $this->{$column};
        }
    }

    /**訂購人 */
    private function handleUser(){
        if($this->user_id){
            if($user = User::find($this->user_id)){
                $this->orderResource->user = $user;
            }
        }
    }

    /**地址 */
    private function handleAddress(){
        if($address = Address::find($this->shipping_address_id)){
            $this->orderResource->address = $address;
        }
    }

    /**物流 */
    private function handleCarrier(){
        $this->orderResource->carrier = '';
        if($carrier = Carrier::find($this->carrier_id)){
            $this->orderResource->carrier = $carrier->name;
        }
    }

    /**金流 */
    private function handlePayment(){
        $this->orderResource->payment = '';
        if($payment = Payment::find($this->payment_id)){
            $this->orderResource->payment = $payment->name;
        }
    }

    /**訂單狀態 */
    private function handleStatus(){
        $statusDict = Order::$statusDict;
        $this->orderResource->status = '';
        if(isset($statusDict[$this->status_id])){
            $this->orderResource->status = $statusDict[$this->status_id];
        }
    }

    /**訂單商品 */
    private function handleOrderProducts(){
        $this->orderResource->productList = [];
        $orderProducts = $this->orderProducts()->get();
        if(!empty($orderProducts)){
            $orderProductCollection = new OrderProductCollection($orderProducts);
            $this->orderResource->productList = $orderProductCollection->withFirstImage()->toArray();
        }
    }
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = null)
    {

        $this->handleInitColumns();
        $this->handleUser();
        $this->handleAddress();
        $this->handleCarrier();
        $this->handlePayment();
        $this->handleStatus();
        $this->handleOrderProducts();

        return $this->orderResource;
    }
}



// {
//     "order_numero": "603354888ff4d",
//     "bonus_cost": 0,
//     "total_discount": "0.00",
//     "total_shipping": "150.00",
//     "total": "725.00",
//     "created_at": "2021-02-22T06:51:52.000000Z",
//     "user": {
//         "id": 1,
//         "name": "beta",
//         "email": "beta0221@gmail.com",
//         "email_verified_at": null,
//         "birthday": "2020-12-08",
//         "gender": 1,
//         "bonus": 50,
//         "active": 1,
//         "created_at": "2020-12-03T08:10:35.000000Z",
//         "updated_at": "2021-02-09T08:23:49.000000Z"
//     },
//     "address": {
//         "id": 34,
//         "user_id": 1,
//         "country_id": 886,
//         "name": null,
//         "address1": "\u5927\u6709\u8def61-1\u865f",
//         "address2": null,
//         "county": "\u6843\u5712\u5e02",
//         "city": "\u9f8d\u6f6d\u5340",
//         "postal_code": "325",
//         "phone": "0911224280",
//         "mobile_phone": null,
//         "comment": null,
//         "created_at": "2021-02-22T06:51:52.000000Z",
//         "updated_at": "2021-02-22T06:51:52.000000Z"
//     },
//     "carrier": "\u9ed1\u8c93\u5b85\u914d",
//     "payment": "\u8ca8\u5230\u4ed8\u6b3e",
//     "status": "\u5f85\u51fa\u8ca8",
//     "productList": [
//         {
//             "name": "\u632a\u5a01\u9bd6\u9b5a",
//             "sku": "fish_c",
//             "price": "100.00",
//             "quantity": 2,
//             "imageUrl": "http:\/\/localhost:8000\/storage\/default_product_image.png"
//         },
//         {
//             "name": "\u91d1\u994c\u96de\u817f",
//             "sku": "chicken_a",
//             "price": "100.00",
//             "quantity": 3,
//             "imageUrl": "http:\/\/localhost:8000\/storage\/default_product_image.png"
//         },
//         {
//             "name": "\u539a\u5207\u6392\u9aa8",
//             "sku": "pork_001",
//             "price": "75.00",
//             "quantity": 1,
//             "imageUrl": "http:\/\/localhost:8000\/storage\/product\/pork_001\/Qt5TjEkCjknkekVfRrwh5333ItrGBXyRXIOL8kVF.jpeg"
//         }
//     ]
// }