@extends('layouts.main')
    @section('title','購買成功')
        @section('css')
        @endsection
    @section('content') 
    
        @include('components.breadcrumb',['crumbs'=>[
            ['url'=>'/order/myOrder','name'=>'我的訂單'],
            ['url'=>null,'name'=>$OR->order_numero]
        ]])
    
        
        <div class="container mt-4 mb-4">

            <div class="row">
                <div class="col-md-12 mt-2 mb-2">
                    <h4>訂單編號 : {{$OR->order_numero}}（{{$OR->status}}）</h4>
                </div>
            </div>
            <hr class="m-0">
            
            <div class="row">
                <div class="col-md-12 mt-2 mb-2">
                    <h4>訂購資訊</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-2">
                    付款方式：{{$OR->payment}}
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-2">
                    運送方式：{{$OR->carrier}}
                </div>
            </div>

            @if ($OR->address)
            @include('components.orderAddress',['address'=>$OR->address])
            @endif

            @if (count($OR->cartRules))
            <div class="row">
                <div class="col-md-4 col-sm-12 mt-4 mb-2 ">
                    @include('components.orderCartRules',['cartRules'=>$OR->cartRules])
                </div>
            </div>
            @endif

            @if ($OR->atmInfo)
                @include('components.orderATM',['atmInfo'=>$OR->atmInfo])
            @endif

            @if ($OR->cardInfo)
            <div class="row">
                <div class="col-md-12 mt-2 mb-2">
                    <h4>信用卡資訊</h4>
                    卡片末四碼：{{$OR->cardInfo->Card4No}}
                </div>
            </div>
            
            @endif

            <div class="row">
                <div class="col-md-12 mt-2 mb-2">

                    @include('components.productListTable',['productList'=>$OR->productList])

                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-3 offset-md-9">
                    @include('components.orderTotal',['OR'=>$OR])
                </div>
            </div>
        </div>


    @endsection