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
                        <th style="border: 0px"><h4>{{$user->name}} 的訂單 <h4></th>
                        </tr>
                        <tr>
                            <th>訂單編號</th>
                            <th>狀態</th>
                            <th>總金額</th>
                            <th>下單日期</th>
                            <th>詳細內容</th>
                        </tr>                      
                    </thead>       
                    @foreach ($myOrderList as $myOrder)
                        <tr>  
                                <td class="align-middle">{{$myOrder->order_numero}}</td>
                                <td class="align-middle">{{$myOrder->status_id}}</td>     
                                <td class="align-middle">{{$myOrder->total}}</td>
                                <td class="align-middle">{{$myOrder->created_at}}</td>
                                <td>
                                    <button class="btn btn-primary">詳細</button>
                                </td>
                                
                            </tr>            
                    @endforeach       
                    
                </table>
            </div>
        </div>


    @endsection
    @section('js')
    <script>
        
    </script>
    @endsection