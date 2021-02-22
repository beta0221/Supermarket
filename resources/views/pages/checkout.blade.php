@extends('layouts.main')

@section('title','結帳')

@section('css')
<style>
    .nice-select{
        width:100%;
        padding: 0 12px;
    }
    .nice-select ul{
        width:100%;
    }
</style>
@endsection

@section('content')

@include('components.breadcrumb')

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">

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
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($cartHandler->finalCartItems as $row)
                            <tr>
                                <td class="shoping__cart__item">
                                    <img style="width:100px;height:100" src="{{$row->product->getFirstImageUrl()}}">
                                    <h5>{{$row->name}}</h5>
                                </td>
                                <td class="shoping__cart__price">
                                    ${{$row->price}}
                                </td>
                                <td class="shoping__cart__quantity">
                                    {{$row->qty}}
                                </td>
                                <td class="shoping__cart__total">
                                    ${{$row->subtotal}}
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>

            </div>
        </div>


        <div class="checkout__form">
            <h4>Billing Details</h4>


            <form action="{{route('submitCheckout')}}" method="POST">
                @csrf
                <div class="row">

                    
                    <div class="col-lg-8 col-md-6">
                        
                        
                        <div class="checkout__input">
                            <p>運送方式<span>*</span></p>
                            <select class="form-control" name="carrier_id" id="carrier_id">
                                <option value="">運送方式</option>
                                @foreach ($carriers as $carrier)
                                <option value="{{$carrier->id}}">{{$carrier->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="checkout__input">
                            <p>付款方式<span>*</span></p>
                            <select class="form-control" name="payment_id" id="payment_id">
                                <option value="">付款方式</option>
                            </select>
                        </div>


                        <div class="checkout__input">
                            <p>訂購人姓名<span>*</span></p>
                            <input type="text" name="name">
                        </div>

                        <div class="checkout__input">
                            <p>聯絡電話<span>*</span></p>
                            <input type="text" name="phone">
                        </div>

                        
                        <div class="checkout__input">
                            <p>國家<span>*</span></p>
                            <select class="form-control mb-2" name="country_id" id="country_id">
                                @foreach ($countries as $country)
                                <option value="{{$country->code}}">{{$country->name}}</option>
                                @endforeach
                            </select>

                            <p>地址<span>*</span></p>
                            <select class="form-control mb-2" name="county" id="county">
                                <option value="">縣市</option>
                                @foreach ($counties as $county)
                                <option value="{{$county}}">{{$county}}</option>    
                                @endforeach
                            </select>

                            <select class="form-control mb-2" name="postal_code" id="postal_code">
                                <option value="">地區</option>
                            </select>

                            <input type="text" placeholder="地址" class="checkout__input__add" name="address1">

                        </div>

                        <div class="checkout__input mb-0">
                            <p class="mb-1">希望到貨日:</p>
                        </div>

                        <div>
                            <input id="delivery-date-null" type="radio" name="delivery_date_radio" value="0" checked>
                            <label class="mr-2" for="delivery-date-null">不指定</label>
                            <input id="delivery-date-on" type="radio" name="delivery_date_radio" value="1">
                            <label class="mr-2" for="delivery-date-on">指定</label>
                        </div>
                        
                        <div id="delivery-date-input" class="checkout__input" style="display: none">
                            <input type="date" name="delivery_date">
                        </div>

                        <?php $delivery_time_array = config('shop.delivery_time_array'); ?>
                        
                        @if (empty($delivery_time_array))
                        <input id="delivery-time-null" type="radio" name="delivery_time" value="" hidden checked>
                        @else
                        <div class="checkout__input mb-0">
                            <p class="mb-1">到貨時段:</p>
                        </div>
                        <div>
                            <input id="delivery-time-null" type="radio" name="delivery_time" value="" checked>
                            <label class="mr-2" for="delivery-time-null">不指定</label>
                            @foreach ($delivery_time_array as $index => $delivery_time)
                            <input id="delivery-time-{{$index}}" type="radio" name="delivery_time" value="{{$delivery_time}}">
                            <label class="mr-2" for="delivery-time-{{$index}}">{{$delivery_time}}</label>    
                            @endforeach
                        </div>
                        @endif
                        
                        

                        <div class="checkout__input mt-2">
                            <p>備註</p>
                            <input type="text"
                                name="comment"
                                placeholder="備註...">
                        </div>

                        {{-- <div class="checkout__input">
                            <p>Town/City<span>*</span></p>
                            <input type="text">
                        </div>
                        <div class="checkout__input">
                            <p>Country/State<span>*</span></p>
                            <input type="text">
                        </div>
                        <div class="checkout__input">
                            <p>Postcode / ZIP<span>*</span></p>
                            <input type="text">
                        </div> --}}
                        {{-- <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Phone<span>*</span></p>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="text">
                                </div>
                            </div>
                        </div> --}}


                        {{-- <div class="checkout__input__checkbox">
                            <label for="acc">
                                Create an account?
                                <input type="checkbox" id="acc">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <p>Create an account by entering the information below. If you are a returning customer
                            please login at the top of the page</p>
                        <div class="checkout__input">
                            <p>Account Password<span>*</span></p>
                            <input type="text">
                        </div>
                        <div class="checkout__input">
                            <p>Confirm Password<span>*</span></p>
                            <input type="text">
                        </div> --}}

                        {{-- <div class="checkout__input__checkbox">
                            <label for="diff-acc">
                                Ship to a different address?
                                <input type="checkbox" id="diff-acc">
                                <span class="checkmark"></span>
                            </label>
                        </div> --}}
                        
                    </div>


                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Your Order</h4>
                            <div class="checkout__order__products">Subtotal <span>${{$cartHandler->subtotal}}</span></div>
                            <div class="checkout__order__products">運費 <span>${{$cartHandler->delivery_fee}}</span></div>
                            <div class="checkout__order__products">Discount <span>-${{$cartHandler->discount}}</span></div>
                            <div class="checkout__order__subtotal">Total <span>${{$cartHandler->total}}</span></div>

                            <div class="checkout__input__checkbox">
                                <label for="acc-or">
                                    Create an account?
                                    <input type="checkbox" id="acc-or">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adip elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua.</p>
                            <div class="checkout__input__checkbox">
                                <label for="payment">
                                    Check Payment
                                    <input type="checkbox" id="payment">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    Paypal
                                    <input type="checkbox" id="paypal">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <button type="submit" class="site-btn">PLACE ORDER</button>
                        </div>
                    </div>


                </div>
            </form>


        </div>
    </div>
</section>
<!-- Checkout Section End -->
@endsection

@section('js')
<script>
    const cities = {!!json_encode($cities)!!};
    const payments = {!!json_encode($payments)!!};
</script>
<script src="/js/checkout.js"></script>
@endsection