<div class="product__pagination">
    @for ($page = 1; $page <= $pagination->totalPage; $page++)
    
    <a href="{{Request::url()}}?page={{$page}}"
        class="{{($pagination->page == $page)?'active':''}}">
        {{$page}}</a>  
    @endfor
    @if ($pagination->hasNextPage)
    <a href="{{Request::url()}}?page={{$pagination->page +1}}"><i class="fa fa-long-arrow-right"></i></a>   
    @endif
</div>