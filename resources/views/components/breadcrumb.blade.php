<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="/img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>金園排骨</h2>
                    <div class="breadcrumb__option">
                        <a href="/">首頁</a>
                        @if (isset($crumbs))
                            @foreach($crumbs as $crumb)
                                @if ($crumb['url'] != null)
                                <a href="{{$crumb['url']}}">{{$crumb['name']}}</a>
                                @else
                                <span>{{$crumb['name']}}</span>
                                @endif
                            @endforeach
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->