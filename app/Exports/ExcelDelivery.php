<?php

namespace App\Exports;

use App\Address;
use App\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class ExcelDelivery implements FromCollection,WithHeadings
{
    
    private $orders;
    private $dataRows;

    use Exportable;
    public function __construct($orders)
    {
        date_default_timezone_set('Asia/Taipei');
        $this->orders = $orders;
        $this->genDataRows();
    }


    private function genDataRows(){
        $now = date('Y/m/d');
        $arrive = date('Y/m/d',strtotime('3 day'));
        $paymentDict = Payment::getPaymentDict();
        $deliveryTimeDict = array_flip(config('shop.delivery_time_array'));
        
        foreach ($this->orders as $order) {

            $address = Address::find($order->shipping_address_id);
            if(!$address){ continue; }

            $deliveryTime = '1';
            if(isset($deliveryTimeDict[$order->delivery_time])){
                $deliveryTime = $deliveryTimeDict[$order->delivery_time];
            }

            $cash = null;
            if($order->payment_id == Payment::PAYMENT_ID_COD){
                $cash = $order->total;
            }

            $note = null;
            if(isset($paymentDict[$order->payment_id])){
                $note = '官網' . $paymentDict[$order->payment_id];
            }

            $items = '';
            $orderProducts = $order->orderProducts()->get();
            foreach ($orderProducts as $OP) {
                $items .= $OP->sku . '*' . $OP->quantity . ';';
            }

            $deliveryDate = $arrive;
            if($order->delivery_date){
                $deliveryDate = date('Y/m/d',strtotime($order->delivery_date));
            }

            $row = [
                $order->created_at->format("Y/m/d H:m:s"),// 訂購日期
                $order->order_numero,// 訂單編號
                $note,// 備註
                $cash,// 代收貨款
                $deliveryTime,// 配送時段
                $address->name,// 收件人
                $address->phone,// 電話
                $items,// 品名
                $address->address1,// 收件地址
                $now,// 出貨日期
                $deliveryDate,// 到貨日期
                $order->total// 金額
            ];
            $this->dataRows[] = $row; 
        }
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->dataRows);
    }



    public function headings(): array
    {
        return [
            '訂購日期',//A
            '訂單編號',//B
            '備註',
            '代收貨款',
            '配送時段',
            '收件人',//F
            '電話',//G
            '品名',//H
            '收件地址',//I
            '出貨日期',
            '到貨日期',
            '金額',
        ];
    }

}
