<?php
namespace App\Helpers;

use App\Order;

class ECPay{


    /** 介接路徑 */
    private $endpoint = "https://ecpg-stage.ecpay.com.tw/Merchant/GetTokenbyTrade";
    /** 特店編號 */
    private $MerchantID;
    /** 串接文件版號 */
    private $Revision = "1.0.0";
    /** 是否使用記憶卡號 0否 1是 */
    private $RememberCard = 0;
    /** 畫面的呈現方式 */
    private $PaymentUIType = 2;
    /** 欲使用的付款方式 1.信用卡付清 3.ATM */
    private $ChoosePaymentList = "1,3";

    //OrderInfo

    /** 特店交易編號 */
    private $MerchantTradeNo;
    /** 交易時間 (yyyy/MM/dd HH:mm:ss) */
    private $MerchantTradeDate;
    /** 交易金額 */
    private $TotalAmount;
    /** 付款回傳結果URL（POST） */
    private $ReturnURL = '';
    /** 交易描述 */
    private $TradeDesc = '';
    /** 商品名稱（以#分隔） */
    private $ItemName = '';

    //CardInfo

    /** 3D驗證回傳付款結果URL（POST） */
    private $OrderResultURL;

    //ATMInfo

    /** 允許繳費有效天 */
    private $ExpireDate = 3;

    //ConsumerInfo

    /** 消費者會員編號（當[RememberCard] = 1，此欄位必填） */
    private $MerchantMemberID;
    /** 信用卡持卡人電子信箱 */
    private $Email;
    /** 信用卡持卡人電話 */
    private $Phone;
    /** 信用卡持卡人姓名 */
    private $Name;
    /** 國別碼 */
    private $CountryCode;



    public function __construct(Order $order)
    {

        
        if(config('app.env') == "production"){
            $this->endpoint = "https://ecpg.ecpay.com.tw/Merchant/GetTokenbyTrade";
        }
        $this->MerchantID = config('ecpay.MerchantId');
        $this->MerchantTradeNo = $order->order_numero;
        $this->MerchantTradeDate = $order->created_at;
        $this->TotalAmount = $order->total;
        $this->setItemName($order);

        



    }

    /**
     * 組合ItemName
     * @param Order $order 
     * @return void
     * */
    private function setItemName(Order $order){
        $nameList = $order->orderProducts()->pluck('name');
        foreach ($nameList as $name) {
            if(!empty($this->ItemName)){ $this->ItemName .= "#"; }
            $this->ItemName .= $name;
        }
    }

    /** 
     * 取得付款token
     * @return string 
     */
    public function getToken(){
        return '';
    }

}