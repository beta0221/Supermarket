<h3>感謝您的購買</h3>
<h4>訂單編號 : {{$OR->order_numero}}（{{$OR->status}}）</h4>
@if ($OR->address)
<h4>訂購資訊</h4>
@include('components.orderAddress',['address'=>$OR->address])
@endif

@include('components.productListTable',['productList'=>$OR->productList])

@include('components.orderTotal',['OR'=>$OR])