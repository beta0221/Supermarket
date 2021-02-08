@extends('layouts.main')

@section('title','購物車')

@section('css')
<style>
    #cart-content-form form input{
        width: 255px;
        height: 46px;
        border: 1px solid #cccccc;
        font-size: 16px;
        color: #b2b2b2;
        text-align: center;
        display: inline-block;
        margin-right: 15px;
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

        <div class="row">

            <div class="col-lg-6 offset-lg-6">
                <div class="shoping__continue">
                    <div class="shoping__discount">
                        <h5>折扣碼</h5>
                        {{-- <form action="#">    
                            <input type="text" placeholder="Enter your coupon code">
                            <button type="submit" class="site-btn">APPLY COUPON</button>
                        </form> --}}
                        <input type="text" placeholder="coupon code">
                        
                        <h5>紅利折抵</h5>
                        <input type="text" placeholder="紅利折抵" name="bonus_cost" value="{{$cartHandler->bonus_cost}}">
                    </div>
                </div>
            </div>
        </div>

        </form>


        <div class="row">

            <div class="col-lg-12">
                <div class="shoping__cart__btns">
                    <a href="{{route('shop')}}" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                    <a href="javascript:;" onclick="updateCartQty()" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                        Upadate Cart</a>
                </div>
            </div>

            <div class="col-lg-6">
                
            </div>

            <div class="col-lg-6">
                <div class="shoping__checkout">
                    <h5>Cart Total</h5>
                    <ul>
                        <li>Subtotal <span>${{$cartHandler->subtotal}}</span></li>
                        <li>運費 <span>${{$cartHandler->delivery_fee}}</span></li>
                        <li>Discount <span>-${{$cartHandler->discount}}</span></li>
                        <li>Total <span>${{$cartHandler->total}}</span></li>
                    </ul>
                    <a href="{{route('checkout')}}" class="primary-btn">PROCEED TO CHECKOUT</a>
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