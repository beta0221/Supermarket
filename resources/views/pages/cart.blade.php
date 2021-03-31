@extends('layouts.main')

@section('title','購物車')

@section('css')
<style>
    .shoping__discount input{
        width: 100%;
        height: 46px;
        border: 1px solid #cccccc;
        font-size: 16px;
        color: #b2b2b2;
        text-align: center;
        display: inline-block;
        margin-right: 15px;
    }
    .step-title h5{
        color: rgb(160, 37, 37);
        font-size: 24px;
        font-weight: 600;
    }

    .price-list-table td{
        padding: 8px 24px;
        border: 1px solid gray;
    }
</style>
@endsection

@section('content')

@include('components.breadcrumb')

<!-- Shoping Cart Section Begin -->
<section class="shoping-cart spad">
    <div class="container">

        <form id="cart-content-form" action="/cart/update" method="POST">
        <input name="_method" type="hidden" value="PUT">
        @csrf

        <div class="row mb-2">
            <div class="col-lg-6 offset-lg-6 step-title">
                <h5>1.調整購買產品數量</h5>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th class="shoping__product">產品</th>
                                <th class="text-left">價格</th>
                                <th>數量</th>
                                <th>小計</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($cartHandler->finalCartItems as $row)
                            <input name="rowIdArray[]" type="hidden" value="{{$row->rowId}}">
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img style="width:100px;height:100" src="{{$row->product->getFirstImageUrl()}}">
                                        <h5>
                                            <a class="common-a" href="{{route('productDetail',['sku'=>$row->sku])}}">{{$row->name}}</a>
                                        </h5>
                                    </td>
                                    <td class="shoping__cart__price text-left">
                                        ${{$row->price}}
                                        <span style="font-size: 14px">(<a class="common-a" href="javascript:;" onclick="showPriceList('{{$row->sku}}')">價目表</a>)</span>
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input name="qty_{{$row->rowId}}" type="text" value="{{$row->qty}}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                        ${{$row->subtotal}}
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <span onclick="deleteFromCart('{{$row->rowId}}')" class="icon_close"></span>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-6 offset-lg-6 step-title">
                <h5 class="mb-2">2.按下計算總金額按鈕</h5>
                <div>
                    <a href="javascript:;" onclick="updateCartQty()" class="primary-btn cart-btn btn-block text-center">
                        <span class="mr-2 icon_loading"></span>
                        計算金額
                    </a>
                </div>
            </div>
        </div>
        

        <div class="row mb-2">
            <div class="col-lg-6 offset-lg-6 step-title">
                <h5>3.使用紅利折抵</h5>
            </div>
        </div>

        <div class="row mb-4">

            <div class="col-lg-6 offset-lg-6">
                <div class="shoping__continue">
                    <div class="shoping__discount mt-1">
                        
                        {{-- <h5 class="mb-1">折扣碼</h5>
                        @if(Session::has('success'))
                        <p class="alert alert-success">{{ Session::get('success') }}</p>
                        @elseif(Session::has('error'))
                        <p class="alert alert-danger">{{ Session::get('error') }}</p>
                        @endif
                        <input class="mb-3" type="text" placeholder="coupon code" name="coupon_code" value="{{$cartHandler->coupon_code}}"> --}}
                        
                        <?php $user = Auth::user(); ?>
                        <h5 class="mb-1">紅利折抵{{($user)?'（剩餘：'.$user->bonus.'）':'（請先登入）'}}</h5>
                        <input {{(!$user)?'disabled':''}} class="mb-3" type="text" placeholder="紅利折抵" name="bonus_cost" value="{{$cartHandler->bonus_cost}}">
                        
                    </div>
                </div>

                <div>
                    <a href="javascript:;" onclick="updateCartQty()" class="primary-btn cart-btn btn-block text-center">
                        {{-- <span class="mr-2 icon_loading"></span> --}}
                        確定使用
                    </a>
                </div>
            </div>
        </div>

        </form>
        
        <div class="row mb-2 mt-4">
            <div class="col-lg-6 offset-lg-6 step-title">
                <h5>4.確定金額，前往結帳</h5> 
            </div>
        </div>

        @if (!empty($cartHandler->cartRules))
        <div class="row mt-2">
            <div class="col-lg-6 offset-lg-6" >
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">已使用的折扣 : </h4>
                    <hr class="mt-2 mb-2">
                    @foreach ($cartHandler->cartRules as $cartRule)
                    <p style="color:#155724" class="mb-0">＊{{$cartRule->name}}</p>
                    @endforeach
                </div>
            </div> 
        </div>
        @endif

        <div class="row">

            <div class="col-lg-6">
                
            </div>

            <div class="col-lg-6">
                <div class="shoping__checkout mt-1">
                    <h5>訂單總額</h5>
                    <ul>
                        <li>小計 <span>${{$cartHandler->subtotal}}</span></li>
                        <li>運費 <span>${{$cartHandler->delivery_fee}}</span></li>
                        <li>折扣 <span>-${{$cartHandler->discount}}</span></li>
                        <li>總額 <span>${{$cartHandler->total}}</span></li>
                    </ul>
                    <a href="{{route('checkout')}}" class="primary-btn">確定結帳</a>
                </div>
            </div>

        </div>

    </div>
</section>
<!-- Shoping Cart Section End -->

<!-- Modal -->
<div class="modal fade" id="priceTableModal" tabindex="-1" role="dialog" aria-labelledby="priceTableModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="priceTableModalLabel">-價目表</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="/js/jquery.nice-select.min.js"></script>
<script>
    jQuery(function(){
        $("select").niceSelect();
    });
    

    function updateCartQty(){
        $('#cart-content-form').submit();
    }

    function showPriceList(sku){
        $('#priceTableModal .modal-title').empty();
        $('#priceTableModal .modal-body').empty();
        $.ajax({
        type: "GET",
        url: "/api/product/priceList/"+sku,
        dataType: "json",
        success: function (res) {
            $('#priceTableModal').modal('show');
            $('#priceTableModal .modal-title').html("價目表-"+res.name);
            $('#priceTableModal .modal-body').append(priceListTable(res.priceList));
        },
        error:function(error){
            flashMessage('系統錯誤。','danger');
        }
    });
    }
</script>
@endsection