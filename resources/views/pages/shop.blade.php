@extends('layouts.main')

@section('title','商品列表')

@section('css')

@endsection

@section('content')

    <?php 
        $crumbs = [
            ['url'=>null,'name'=>'所有商品']
        ];
        if ($catName != null) {
            $crumbs = [
                ['url'=>'/shop','name'=>'所有商品'],
                ['url'=>null,'name'=>$catName],
            ];
        }
    ?>
    @include('components.breadcrumb',['crumbs'=>$crumbs])

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        
        <div class="row">
            <div class="col-lg-3 col-md-5">
                <div class="sidebar">
                    
                    @if (count($categories) > 0)
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
                    @endif

                    
                    {{-- <div class="sidebar__item">
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
                                        {{-- <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                            <li><a href="javascript:;" onclick="addToCart('{{$product->sku}}')"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul> --}}
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


                <div class="row">
                    @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{$product->imageUrl}}">
                                <a style="display: block; width:268px; height:270px;z-index:-1;" href="/product/{{$product->sku}}"></a>
                                {{-- <ul class="product__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                    <li><a href="javascript:;" onclick="addToCart('{{$product->sku}}')"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul> --}}
                            </div>
                            @if (!$product->priceOnSale)
                            <div class="product__item__text">
                                <h6><a href="/product/{{$product->sku}}">{{$product->name}}</a></h6>
                                @if ($product->price == $product->lowest_price)
                                <h5>${{$product->price}}</h5>
                                @else
                                <h5>${{$product->lowest_price}}~${{$product->price}}</h5>
                                @endif
                                    
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