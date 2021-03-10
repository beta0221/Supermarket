<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">使用折扣 : </h4>
    <hr class="mt-2 mb-2">
    @foreach ($cartRules as $cartRule)
    <p style="color:#155724" class="mb-0">＊{{$cartRule}}</p>
    @endforeach
</div>