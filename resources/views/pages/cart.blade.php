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
                                <th class="shoping__product">Products</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($cartHandler->finalCartItems as $row)
                            <input name="rowIdArray[]" type="hidden" value="{{$row->rowId}}">
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img style="width:100px;height:100" src="{{$row->product->getFirstImageUrl()}}">
                                        <h5>{{$row->name}}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        ${{$row->price}}
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

        <div class="row mb-2">
            <div class="col-lg-6 offset-lg-6 step-title">
                <h5>2.使用折扣碼或紅利</h5>
            </div>
        </div>


        <div class="row mb-2">

            <div class="col-lg-6 offset-lg-6">
                <div class="shoping__continue">
                    <div class="shoping__discount mt-1">
                        
                        
                        <h5 class="mb-1">折扣碼</h5>
                        <input class="mb-3" type="text" placeholder="coupon code" name="coupon_code" value="{{$cartHandler->coupon_code}}">
                        
                        <h5 class="mb-1">紅利折抵</h5>
                        <?php $auth = Auth::check(); ?>
                        @if (!$auth)
                        <div class="alert alert-warning" role="alert">請先登入</div>
                        @endif
                        <input {{(!$auth)?'disabled':''}} class="mb-3" type="text" placeholder="紅利折抵" name="bonus_cost" value="{{$cartHandler->bonus_cost}}">
                        

                        
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-lg-6 offset-lg-6 step-title">
                <h5 class="mb-2">3.按下計算總金額按鈕</h5>
                <div>
                    <a href="javascript:;" onclick="updateCartQty()" class="primary-btn cart-btn btn-block text-center">
                        <span class="mr-2 icon_loading"></span>
                        計算金額
                    </a>
                </div>
            </div>
        </div>

        </form>



        <div class="row mb-2">
            <div class="col-lg-6 offset-lg-6 step-title">
                <h5>4.確定金額，前往結帳</h5>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-6">
                
            </div>

            <div class="col-lg-6">
                <div class="shoping__checkout mt-1">
                    <h5>Cart Total</h5>
                    <ul>
                        <li>Subtotal <span>${{$cartHandler->subtotal}}</span></li>
                        <li>運費 <span>${{$cartHandler->delivery_fee}}</span></li>
                        <li>Discount <span>-${{$cartHandler->discount}}</span></li>
                        <li>Total <span>${{$cartHandler->total}}</span></li>
                    </ul>
                    <a href="{{route('checkout')}}" class="primary-btn">確定結帳</a>
                </div>
            </div>

        </div>

    </div>
</section>
<!-- Shoping Cart Section End -->

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
</script>
@endsection