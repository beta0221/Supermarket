@extends('layouts.main')
    @section('title','購買成功')
        @section('css')
        @endsection
    @section('content') 
        @include('components.breadcrumb')
    
        
        <div class="container mt-4 mb-4">

            <div class="row">
                <div class="col-md-12 mt-2 mb-2">
                    <h4>訂單編號 : {{$OR->order_numero}}（{{$OR->status}}）</h4>
                </div>
            </div>
            <hr class="m-0">
            
            @if ($OR->address)
            <div class="row">
                <div class="col-md-12 mt-2 mb-2">
                    <h4>訂購資訊</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    收件人：{{$OR->address->name}}
                </div>
                <div class="col-md-12">
                    電話：{{$OR->address->phone}}
                </div>
                <div class="col-md-12">
                    地址：{{$OR->address->county}}{{$OR->address->city}}{{$OR->address->address1}}
                </div>
            </div>
            @endif


            <div class="row">
                <div class="col-md-12 mt-2 mb-2">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>訂購商品</th>
                                <th>單項價格</th>
                                <th>數量</th>
                                <th>價格</th>
                            </tr>                      
                        </thead>       
                        @foreach ($OR->productList as $op)
                            <tr>  
                                <td>
                                <img style="width: 70px" src="{{$op->imageUrl}}" alt="">
                                   <span class="ml-4">{{$op->name}}</span></td>
                                    <td class="align-middle">{{$op->price}}</td>
                                    <td class="align-middle">{{$op->quantity}}</td>     
                                    <td class="align-middle">{{$op->price * $op->quantity}}</td>
                                </tr>            
                        @endforeach       
                    </table>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-3 offset-md-9">
                    {{-- <h4>小記：<span>${{$OR->total}}</span></h4> --}}
                    <h4 class="mb-1">運費：<span>${{$OR->total_shipping}}</span></h4>
                    <h4 class="mb-1">折扣：<span>${{$OR->total_discount}}</span></h4>
                    <h4 class="mb-1">總額：<span class="text-success">${{$OR->total}}</span></h4>
                </div>
            </div>
        </div>


    @endsection