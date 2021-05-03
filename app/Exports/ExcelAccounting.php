<?php

namespace App\Exports;

use App\Address;
use App\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class ExcelAccounting implements FromCollection,WithHeadings
{

    private $orders;
    private $addressDict = [];
    private $dataRows;

    use Exportable;
    public function __construct($orders)
    {
        date_default_timezone_set('Asia/Taipei');
        $this->orders = $orders;
        $this->genAddressDict();
        $this->genDataRows();
    }

    /**
     * Address 字典 
     * key => value
     * address->id => {$address}
     * */
    private function genAddressDict(){
        $addressIdArray = [];
        foreach ($this->orders as $order) {
            $addressIdArray[] = $order->shipping_address_id;
        }
        $addressList = Address::whereIn('id',$addressIdArray)->get();
        foreach ($addressList as $address) {
            $this->addressDict[$address->id] = $address;
        }
    }

    private function genDataRows(){
        $now = date('Y-m-d');
        $paymentDict = Payment::getPaymentDict();


        foreach ($this->orders as $order) {

            if(!isset($this->addressDict[$order->shipping_address_id])){ continue; }
            $address = $this->addressDict[$order->shipping_address_id];

            $payType = null;
            if(isset($paymentDict[$order->payment_id])){
                $payType = '官網' . $paymentDict[$order->payment_id];
            }

            $invoiceType = 2;
            $invoiceCompanyName = null;
            $invoiceCompanyNumero = null;
            if(!empty($order->billing_company_name) && !empty($order->billing_company_numero)){
                $invoiceType = 3;
                $invoiceCompanyName = $order->billing_company_name;
                $invoiceCompanyNumero = $order->billing_company_numero;
            }

            $orderProducts = $order->orderProducts()->get();
            foreach ($orderProducts as $index => $OP) {
                
                $bonus_cost = null;
                $total_price = null;
                $cash = null;
                if($index == 0){
                    $bonus_cost = $order->bonus_cost;
                    $total_price = $order->total;
                    if($order->payment_id == Payment::PAYMENT_ID_COD){
                        $cash = $order->total;
                    }
                }

                $row = [
                    $order->order_numero,//訂單編號
                    $order->created_at->format("Y/m/d H:m:s"),// 訂購日期
                    $now,//交易日期
                    null,//客戶
                    $address->name,//購買人
                    $OP->sku,//商品貨號
                    null,//
                    $OP->name,//商品名稱
                    $OP->quantity,//數量
                    '組',//單位
                    $OP->price,//單價
                    $bonus_cost,//抵扣紅利
                    $total_price,//含稅金額
                    null,//
                    $total_price,//含稅金額
                    $address->name,//收件人
                    null,//郵遞區號
                    $address->address1,//送貨地址
                    $address->phone,//聯絡電話
                    $address->phone,//行動電話
                    null,//代收宅配單號
                    $cash,//代收貨款
                    $payType,//付款方式
                    null,//
                    null,//
                    null,//
                    null,//發票號碼
                    $address->name,//發票收件人
                    $invoiceType,//發票種類
                    $invoiceCompanyNumero,//發票統編
                    $invoiceCompanyName,//買受人名稱
                    null,//
                    null,//
                    null,//
                    null,//
                    null,//
                    null,//信用卡後4碼
                    null,//
                    '官網',//部門
                ];
                $this->dataRows[] = $row; 
            }

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
            '訂單編號','訂單日期','交易日期','客戶','購買人','商品貨號','','商品名稱','數量','單位','單價','抵扣紅利','含稅金額','','含稅金額','收件人','郵遞區號','送貨地址','聯絡電話','行動電話','代收宅配單號','代收貨款','付款方式','','','','發票號碼','發票收件人','發票種類','發票統編','買受人名稱','','','','','','信用卡後4碼','','部門',
        ];
    }


}
