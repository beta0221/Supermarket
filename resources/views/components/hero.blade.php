<!-- Hero Section Begin -->
<?php $static_host = config('app.static_host'); ?>
<section>
    <div class="customize-banner owl-carousel owl-theme">
        @if(count($banners))
            @foreach($banners as $banner)
                <div class="item">
                    <a >
                        <img src="{{$static_host}}/{{$banner->image_path}}" alt="{{$banner->key_word}}">
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