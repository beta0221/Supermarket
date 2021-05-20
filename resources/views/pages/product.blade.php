@extends('layouts.main')

@section('title','產品內容')

@section('css')
<style>
    .product__priceList td{
        padding: 8px 24px;
        border: 1px solid gray;
    }
    .quantity-btn{
        cursor: pointer;
        font-weight: 600;
    }
    .quantity-btn:hover{
        color:gray;
    }
</style>
@endsection

@section('content')
    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            @if(count($imageList))
                            <img class="product__details__pic__item--large" src="{{$imageList[0]["url"]}}">
                            @else
                            <img class="product__details__pic__item--large" src="/storage/default_product_image.png">
                            @endif
                        </div>
                        <div class="product__details__pic__slider owl-carousel">

                            @foreach ($imageList as $image)
                                <img data-imgbigurl="{{$image["url"]}}"
                                src="{{$image["url"]}}" alt="">        
                            @endforeach
                                  
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                    <h3>{{$product->name}}</h3>
                        <div class="product__details__rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 reviews)</span>
                        </div>
                        <div class="product__details__price">

                            @if ($product->price == $product->lowest_price)
                            ${{$product->price}}
                            @else
                            ${{$product->lowest_price}}~${{$product->priceOnsale}}
                            @endif
                            
                        </div>
                        
                        @if (!empty($priceList))
                        <div class="product__priceList mt-3 mb-3">
                            <table class="text-center h4">
                                <tr>
                                    <td>數量</td>
                                    <td>單價</td>
                                </tr>
                                @foreach ($priceList as $quantity => $price)
                                    <tr>
                                        <td>
                                            <div class="btn btn-lg btn-danger" onclick="selectQty({{$quantity}})">{{$quantity}}</div>
                                        </td>
                                        <td>${{$price}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        @endif

                        <div class="product__details__quantity">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input id="add-qty" type="text" value="1">
                                </div>
                            </div>
                        </div>
                        <a href="javascript:;" onclick="addQtyToCart()" class="primary-btn">加入購物車</a>
                        
                        <ul>
                            <li><b>Availability</b> <span>In Stock</span></li>
                            <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
                            <li><b>Weight</b> <span>0.5 kg</span></li>
                            <li><b>Share on</b>
                                <div class="share">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                    aria-selected="true">產品資訊</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                    aria-selected="false">Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                    aria-selected="false">Reviews <span>(1)</span></a>
                            </li> --}}
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    {{-- <h6>產品資訊</h6> --}}
                                    <p>{!!$product->description!!}</p>
                                </div>
                            </div>
                            {{-- <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Products Infomation</h6>
                                    <p>Vestibulum ...</p>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Products Infomation</h6>
                                    <p>Vestibulum ...</p>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>相關產品</h2>
                    </div>
                </div>
            </div>
            @if (!empty($relateToProducts))        
            <div class="row">
                @foreach ($relateToProducts as $product)
                    @if ($product->sku != $sku)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product-image-outter-div">
                                <a href="/product/{{$product->sku}}">
                                    <img src="{{$product->imageUrl}}" alt="{{$product->name}}">
                                </a>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="/product/{{$product->sku}}">{{$product->name}}</a></h6>
                                 <h5>${{$product->lowest_price}}~${{$product->price}}</h5>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            @endif
        </div>
    </section>
    <!-- Related Product Section End -->
@endsection

@section('js')
<script>
    const sku = '{{$product->sku}}';

    function addQtyToCart(){
        let qty = $('#add-qty').val();
        addToCart(sku,qty);
    }

    function selectQty(qty){
        $('#add-qty').val(qty);
    }
</script>
@endsection