<!-- Hero Section Begin -->

<section>
    <div class="customize-banner owl-carousel owl-theme">
        @if(count($banners))
            @foreach($banners as $banner)
                <div class="item">
                    <a >
                        <img src="{{$banner['url']}}" alt="{{$banner['alt']}}">
                    </a>
                </div>
            @endforeach
        @else
        <div class="item">
            <a ><img src="/storage/default_banner.jpg"></a>
        </div>
        @endif
    </div>
</section>
<!-- Hero Section End -->