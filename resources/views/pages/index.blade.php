@extends('layouts.main')

@section('title','首頁')

@section('css')
<style>
    .customize-banner{
        width: 100%;
        height: 30vw;
    }
    .owl-stage-outer,.owl-stage,.owl-item,.item,.item>a>img{
        height: 100%;
    }
</style>
@endsection

@section('content')

@include('components.hero')



<!-- Featured Section Begin -->
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>精選商品</h2>
                </div>
                <div class="featured__controls">
                    <ul>
                        <li class="active" data-filter="*">All</li>
                        @foreach ($categoryWithoutSub as $category)
                            <li data-filter=".cat_{{$category->id}}">{{$category->name}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="row featured__filter">
            @foreach ($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mix @foreach($product->catIdArray as $catId) {{'cat_' . $catId}} @endforeach">
                    <div class="featured__item">
                        <div class="product-image-outter-div">
                            <a href="/product/{{$product->sku}}">
                                <img src="{{$product->imageUrl}}" alt="{{$product->name}}">
                            </a>
                        </div>

                        {{-- <div class="featured__item__pic set-bg" data-setbg="{{$product->imageUrl}}"> --}}
                            {{-- <a style="display: block; width:268px; height:270px;z-index:-1;" href="/product/{{$product->sku}}"></a> --}}
                            {{-- <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="javascript:;" onclick="addToCart('{{$product->sku}}')"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul> --}}
                        {{-- </div> --}}
                        <div class="featured__item__text">
                            <h6><a href="#">{{$product->name}}</a></h6>
                            @if ($product->priceOnSale)
                            <h5 style="color: rgb(241, 64, 64)">${{$product->priceOnSale}}</h5>    
                            @else    

                                @if ($product->price == $product->lowest_price)
                                <h5>${{$product->price}}</h5>
                                @else
                                <h5>${{$product->lowest_price}}~${{$product->price}}</h5>
                                @endif

                            @endif
                        </div>
                    </div>
                </div>
              @endforeach
        </div>
    </div>
</section>
<!-- Featured Section End -->


{{-- <!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">        
                @foreach ($categoryWithoutSub as $category)
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{$category->imageUrl}}">
                        <h5><a href="/shop/{{$category->slug}}">{{$category->name}}</a></h5>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End --> --}}


<!-- Banner Begin -->
<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="img/banner/banner-1.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="img/banner/banner-2.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner End -->

{{-- <!-- Latest Product Section Begin -->
<section class="latest-product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Latest Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-1.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-2.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-3.jpg" alt="">
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
                                    <img src="img/latest-product/lp-1.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-2.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-3.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Popular Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            @if (!empty($popular))
                            @foreach ($popular as $index =>$pop)           
                                @if($index % 3 == 0)
                                <div class="latest-prdouct__slider__item">
                                @endif
                                    <a href="/product/{{$pop->sku}}" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="{{$pop->imageUrl}}" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6>{{$pop->name}}</h6>
                                            <span>${{$pop->price}}</span>
                                        </div>
                                    </a>
                                @if(($index+1) % 3 == 0)
                                </div>
                                @endif
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Review Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        @if (!empty($lastSeen))
                        @foreach ($lastSeen as $index =>$last)           
                            @if($index % 3 == 0)
                            <div class="latest-prdouct__slider__item">
                            @endif
                                <a href="/product/{{$last->sku}}" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{$last->imageUrl}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>{{$last->name}}</h6>
                                        <span>${{$last->price}}</span>
                                    </div>
                                </a>
                            @if(($index+1) % 3 == 0)
                            </div>
                            @endif
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Latest Product Section End --> --}}

<!-- Shop Info Section Begin -->
<section class="from-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title from-blog__title">
                    <h2>各店簡介</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="img/blog/blog-1.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <h5><a href="#">台北-萬年店</a></h5>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="img/blog/blog-2.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <h5><a href="#">桃園-春日店</a></h5>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="img/blog/blog-3.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <h5><a href="#">桃園-長庚店</a></h5>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shop Info Section End -->

{{-- <!-- Blog Section Begin -->
<section class="from-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title from-blog__title">
                    <h2>From The Blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="img/blog/blog-1.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                            <li><i class="fa fa-comment-o"></i> 5</li>
                        </ul>
                        <h5><a href="#">Cooking tips make cooking simple</a></h5>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="img/blog/blog-2.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                            <li><i class="fa fa-comment-o"></i> 5</li>
                        </ul>
                        <h5><a href="#">6 ways to prepare breakfast for 30</a></h5>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="img/blog/blog-3.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                            <li><i class="fa fa-comment-o"></i> 5</li>
                        </ul>
                        <h5><a href="#">Visit the clean farm in the US</a></h5>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End --> --}}
@endsection

@section('js')
<script>
    $(".owl-carousel").owlCarousel({
		loop:true,
		nav:false,
		items:1,
		navText:[],
		autoplay:true,
		autoplaySpeed:1000,
		smartSpeed:500,
	});
</script>

@endsection