@extends('layouts.main')

@section('title','商品列表')

@section('css')

@endsection

@section('content')

    @include('components.breadcrumb')

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5">
                <div class="sidebar">
                    <div class="sidebar__item">
                        <h4>產品類別</h4>
                        <ul>
                            @foreach ($categories as $category)
                            <li>
                                <a href="/shop/{{$category->slug}}">{{$category->name}}</a>
                                @if (isset($category->subCategoryList))
                                <ul>
                                    @foreach ($category->subCategoryList as $cat)
                                    <li class="ml-4">
                                        <a href="/shop/{{$cat->slug}}">{{$cat->name}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    {{-- <div class="sidebar__item">
                        <h4>Price</h4>
                        <div class="price-range-wrap">
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                data-min="10" data-max="540">
                                <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                            </div>
                            <div class="range-slider">
                                <div class="price-input">
                                    <input type="text" id="minamount">
                                    <input type="text" id="maxamount">
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="sidebar__item sidebar__item__color--option">
                        <h4>Colors</h4>
                        <div class="sidebar__item__color sidebar__item__color--white">
                            <label for="white">
                                White
                                <input type="radio" id="white">
                            </label>
                        </div>
                        <div class="sidebar__item__color sidebar__item__color--gray">
                            <label for="gray">
                                Gray
                                <input type="radio" id="gray">
                            </label>
                        </div>
                        <div class="sidebar__item__color sidebar__item__color--red">
                            <label for="red">
                                Red
                                <input type="radio" id="red">
                            </label>
                        </div>
                        <div class="sidebar__item__color sidebar__item__color--black">
                            <label for="black">
                                Black
                                <input type="radio" id="black">
                            </label>
                        </div>
                        <div class="sidebar__item__color sidebar__item__color--blue">
                            <label for="blue">
                                Blue
                                <input type="radio" id="blue">
                            </label>
                        </div>
                        <div class="sidebar__item__color sidebar__item__color--green">
                            <label for="green">
                                Green
                                <input type="radio" id="green">
                            </label>
                        </div>
                    </div> --}}
                    <div class="sidebar__item">
                        <h4>相關內容</h4>
                        <div class="sidebar__item__size">
                            <label for="large">
                                Large
                                <input type="radio" id="large">
                            </label>
                        </div>
                        <div class="sidebar__item__size">
                            <label for="medium">
                                Medium
                                <input type="radio" id="medium">
                            </label>
                        </div>
                        <div class="sidebar__item__size">
                            <label for="small">
                                Small
                                <input type="radio" id="small">
                            </label>
                        </div>
                        <div class="sidebar__item__size">
                            <label for="tiny">
                                Tiny
                                <input type="radio" id="tiny">
                            </label>
                        </div>
                    </div>
                    {{-- <div class="sidebar__item">
                        <div class="latest-product__text">
                            <h4>Latest Products</h4>
                            <div class="latest-product__slider owl-carousel">
                                <div class="latest-prdouct__slider__item">
                                    
                                    <a href="#" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="/img/latest-product/lp-1.jpg" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6>Crab Pool Security</h6>
                                            <span>$30.00</span>
                                        </div>
                                    </a>

                                    <a href="#" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="/img/latest-product/lp-2.jpg" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6>Crab Pool Security</h6>
                                            <span>$30.00</span>
                                        </div>
                                    </a>
                                    <a href="#" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="/img/latest-product/lp-3.jpg" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6>Crab Pool Security</h6>
                                            <span>$30.00</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="latest-prdouct__slider__item">
                                    <a href="#" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="/img/latest-product/lp-1.jpg" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6>Crab Pool Security</h6>
                                            <span>$30.00</span>
                                        </div>
                                    </a>
                                    <a href="#" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="/img/latest-product/lp-2.jpg" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6>Crab Pool Security</h6>
                                            <span>$30.00</span>
                                        </div>
                                    </a>
                                    <a href="#" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="/img/latest-product/lp-3.jpg" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6>Crab Pool Security</h6>
                                            <span>$30.00</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="col-lg-9 col-md-7">

                @if (count($onSaleProducts))
                <div class="product__discount">
                    <div class="section-title product__discount__title">
                        <h2>Sale Off</h2>
                    </div>
                    <div class="row">
                        <div class="product__discount__slider owl-carousel">
                            @foreach ($onSaleProducts as $product)
                            <div class="col-lg-4">
                                <div class="product__discount__item">
                                    <div class="product__discount__item__pic set-bg" data-setbg="{{$product->imageUrl}}">
                                        <a style="display: block; width:268px; height:270px;z-index:-1;" href="/product/{{$product->sku}}"></a>
                                        <div class="product__discount__percent">{{$product->discount}}</div>
                                        <ul class="product__item__pic__hover">
                                            {{-- <li><a href="#"><i class="fa fa-heart"></i></a></li> --}}
                                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                            <li><a href="javascript:;" onclick="addToCart('{{$product->sku}}')"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__discount__item__text">
                                        <span>Dried Fruit</span>
                                    <h5><a href="/product/{{$product->sku}}">{{$product->name}}</a></h5>
                                        <div class="product__item__price">${{$product->priceOnSale}}<span>${{$product->price}}</span></div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
                @endif

                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="filter__sort">
                                <span>Sort By</span>
                                <select>
                                    <option value="0">Default</option>
                                    <option value="0">Default</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                            <h6><span>{{$pagination->total}}</span> Products found</h6>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-3">
                            <div class="filter__option">
                                <span class="icon_grid-2x2"></span>
                                <span class="icon_ul"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{$product->imageUrl}}">
                                <a style="display: block; width:268px; height:270px;z-index:-1;" href="/product/{{$product->sku}}"></a>
                                <ul class="product__item__pic__hover">
                                    {{-- <li><a href="#"><i class="fa fa-heart"></i></a></li> --}}
                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                    <li><a href="javascript:;" onclick="addToCart('{{$product->sku}}')"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            @if (!$product->priceOnSale)
                            <div class="product__item__text">
                                <h6><a href="/product/{{$product->sku}}">{{$product->name}}</a></h6>
                                    <h5>${{$product->lowest_price}}~${{$product->price}}</h5>
                                </div>
                            @else
                            <div class="product__discount__item__text">
                                {{-- <span>Dried Fruit</span> --}}
                            <h5><a href="/product/{{$product->sku}}">{{$product->name}}</a></h5>
                                <div class="product__item__price">${{$product->priceOnSale}}<span>${{$product->price}}</span></div>
                            </div>
                            @endif
                            
                        </div>
                    </div>
                    @endforeach
                </div>
                @include('components.pagination')
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
@endsection

@section('js')
<script>


</script>
@endsection