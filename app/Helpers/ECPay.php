<?php
namespace App\Helpers;

use App\Order;
use Illuminate\Support\Facades\Crypt;

class ECPay{


    /** 介接路徑 */
    private $endpoint = "https://ecpg-stage.ecpay.com.tw/Merchant/GetTokenbyTrade";
    /** 特店編號 */
    private $MerchantID;
    /**Hashkey */
    private $HashKey;
    /**HashIV */
    private $HashIV;
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
        $this->HashKey = config('ecpay.HashKey');
        $this->HashIV = config('ecpay.HashIV');
        $this->MerchantTradeNo = $order->order_numero;
        $this->MerchantTradeDate = $order->created_at->format("Y/m/d H:m:s");
        $this->TotalAmount = (int)$order->total;
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
     * 組合json請求body
     * @return string
     */
    public function getRequestBody(){
        $body = [];
        $body['MerchantID'] = $this->MerchantID;
        $body['RqHeader'] = [
            'Timestamp'=>time(),
            'Revision'=>$this->Revision,
        ];
        $Data = [
            'MerchantID' => $this->MerchantID,
            'RememberCard' => $this->RememberCard,
            'PaymentUIType' => $this->PaymentUIType,
            'ChoosePaymentList' => $this->ChoosePaymentList,
            'OrderInfo' => [
                "MerchantTradeNo" => $this->MerchantTradeNo,
                "MerchantTradeDate" => $this->MerchantTradeDate,
                "TotalAmount" => $this->TotalAmount,
                "ReturnURL" => $this->ReturnURL,
                'TradeDesc' => $this->TradeDesc,
                'ItemName' => $this->ItemName
            ],
            'CardInfo'=> [
                'OrderResultURL' => $this->OrderResultURL,
            ],
            'ATMInfo' => [
                'ExpireDate' => $this->ExpireDate
            ],
            'ConsumerInfo' => [
                "MerchantMemberID"=>$this->MerchantMemberID,
                "Email"=>$this->Email,
                "Phone"=>$this->Phone,
                "Name"=>$this->Name,
                "CountryCode"=>$this->CountryCode,
            ]
        ];
        $Data = json_encode($Data);
        $Data = urlencode($Data);
        $Data = Crypt::encrypt();
        $body['Data'] = $Data;

        return json_encode($body);
    }

    /** 
     * 取得付款token
     * @return string 
     */
    public function getToken(){

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://ecpg-stage.ecpay.com.tw/Merchant/GetTokenbyTrade",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $this->getRequestBody(),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
            ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }







        return '';
    }

}