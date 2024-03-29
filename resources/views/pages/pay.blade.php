@extends('layouts.main')

@section('title','付款')

@section('css')
@endsection

@section('content') 
@include('components.breadcrumb')

<div class="container">

    <div class="row">
        <div class="col-md-12 mt-3" style="text-align: center">
            <h3>進行付款</h3>            
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="ECPayPayment"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form action="/pay/{{$order_numero}}" id="PayProcess" method="post"> 
                <div style="text-align: center;">
                    {{ csrf_field() }}
                    <input id="PaymentType" name="PaymentType" type="hidden" value="" />
                    <input id="btnPay" type="button" class="btn single btn-gray-dark" value="確認付款" />
                </div>
                <br/>
                <div style="text-align: center;">
                    消費者選擇付款方式取得的PayToken : <input id="PayToken" name="PayToken" type="Text" size="50"  value="" />
                </div>
            </form>
        </div>
    </div>

    



</div>

@endsection



@section('js')
<script src ="https://cdn.jsdelivr.net/npm/node-forge@0.7.0/dist/forge.min.js"></script>
<script src="{{$ecpaySDKUrl}}"></script>
<script>


var _token = "{{$token}}";
var env = 'Stage';
$(function(){
    delete $.ajaxSettings.headers["X-CSRF-TOKEN"];
    
    ECPay.initialize(env, 1, function (errMsg) {
        try {
            ECPay.createPayment(_token, ECPay.Language.zhTW, function (errMsg) {
                console.log('Callback Message: ' + errMsg);
                if (errMsg != null){ ErrHandle(errMsg); }
            });
            $('#Language').val(ECPay.Language.zhTW);
        } catch (err) {
            ErrHandle(err);
        }
    });


    //消費者選擇完成付款方式,取得PayToken 
    $('#btnPay').click(function () {
        try {
            ECPay.getPayToken(function (paymentInfo, errMsg) {
                //console.log("response => getPayToken(paymentInfo, errMsg):", paymentInfo, errMsg);
                if (errMsg != null) {
                    ErrHandle(errMsg);
                    return;
                };
                $("#PayToken").val(paymentInfo.PayToken);

                $("#PayProcess").submit();
                return true;
            });
        } catch (err) {
            ErrHandle(err);
        }
    });
    
});


function ErrHandle(strErr) {

    if (strErr != null) {
        $('#ECPayPayment').append('<div style="text-align: center;"><label style="color: red;">' + strErr + '</label></div>');
        console.log(strErr);
    } else {
        $('#ECPayPayment').append('<div style="text-align: center;"><label style="color: red;">Token取得失敗</label></div>');
        console.log('Wrong');
    }

    $('#btnPay').hide();
}

</script>
@endsection