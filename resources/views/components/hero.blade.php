<!-- Hero Section Begin -->
<section class="hero">
    <div class="container">
        <div class="row">


            {{-- <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>產品</span>
                    </div>
                    <ul>
                        @foreach ($categories as $category)
                        <li>
                            <a href="/shop/{{$category->slug}}">{{$category->name}}</a>
                            @if (isset($category->subCategoryList))
                            
                                @foreach ($category->subCategoryList as $cat)
                                <li class="ml-4">
                                    <a href="/shop/{{$cat->slug}}">{{$cat->name}}</a>
                                </li>
                                @endforeach
                            
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div> --}}


            <div class="col-lg-12">

                {{-- <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="#">
                            <div class="hero__search__categories">
                                All Categories
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="text" placeholder="What do yo u need?">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+65 11.188.888</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div> --}}

                <div class="banner__slider owl-carousel">
                    @if(count($banner))

                        @foreach ($banner as $img)

                            <div class="hero__item set-bg" data-setbg="{{$img['url']}}">
                                {{-- <div class="hero__text">
                                    <span>FRUIT FRESH</span>
                                    <h2>Vegetable <br />100% Organic</h2>
                                    <p>Free Pickup and Delivery Available</p>
                                    <a href="/shop" class="primary-btn">SHOP NOW</a>
                                </div> --}}
                            </div>

                        @endforeach
                    
                    @else

                    <div class="hero__item set-bg" data-setbg="/storage/default_banner.jpg">
                        {{-- <div class="hero__text">
                            <span>FRUIT FRESH</span>
                            <h2>Vegetable <br />100% Organic</h2>
                            <p>Free Pickup and Delivery Available</p>
                            <a href="/shop" class="primary-btn">SHOP NOW</a>
                        </div> --}}
                    </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->