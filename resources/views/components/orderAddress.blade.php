<div class="row">
    <div class="col-md-12">
        收件人：{{$address->name}}
    </div>
    <div class="col-md-12">
        電話：{{$address->phone}}
    </div>
    <div class="col-md-12">
        地址：{{$address->county}}{{$address->city}}{{$address->address1}}
    </div>
    <div class="col-md-12">
        配合活動： @foreach ($cartRuleList as $cart)
            <li style="display:inline">{{$cart->name}}</li>
        @endforeach
    </div>
</div>