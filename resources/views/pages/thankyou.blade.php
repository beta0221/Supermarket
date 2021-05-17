@extends('layouts.main')
    @section('title','購買成功')
        @section('css')
        @endsection
    @section('content') 
        
        @include('components.breadcrumb',['crumbs'=>[
            ['url'=>null,'name'=>'購買成功']
        ]])

        <div class="container" style="min-height: 400px">
            <div class="row">
                <div class="col-md-12 mt-4" style="text-align: center">
                    <h3>感謝您的購買</h3>
                    <p>您的貨品將在3-5天之後送達</p>
                    <h3>訂單編號 : {{$order_numero}}</h3>         
                <a href="/order/detail/{{$order_numero}}"><div class="btn btn-success mt-3 mb-3">訂單內容</div></a>
                </div>
            </div>
        </div>


    @endsection