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
            @include('components.orderAddress',['address'=>$OR->address])
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