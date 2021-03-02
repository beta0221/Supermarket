@extends('layouts.main')
    @section('title','購買成功')
        @section('css')
        @endsection
    @section('content') 
        @include('components.breadcrumb')
    
        
        <div class="container">
            <div class="row">
                <table class="table table-hover" style="margin: 2rem">
                    <thead>
                        <tr>
                            <th style="border: 0px"><h4>訂單編號 : {{$OR->order_numero}}<h4></th>
                        </tr>
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
                        <tfoot>
                            <tr>
                                <th colspan="4" style="
                                font-size:1.2rem;
                                padding-right: 6rem;
                                text-align: end;">
                                    總價 :<span class="text-success" style="margin-left: 1.5rem"> {{$OR->total}} </span>
                                </th>
                            </tr>
                        </tfoot>
                </table>
            </div>
        </div>


    @endsection