@extends('layouts.main')
@section('title', '購買成功')
@section('css')
@endsection
@section('content')
    
    @include('components.breadcrumb',['crumbs'=>[
        ['url'=>null,'name'=>'我的訂單']
    ]])


    <div class="container" class="p-1">
        
        <div class="row p-2">
            <h3>{{ $user->name }} 的訂單 </h3>
        </div>
        <div class="row p-2">
            <h4 style="color: red">剩餘紅利:{{$user->bonus}}</h4>
        </div>

        <div class="row">
            <table class="table table-hover" style="">
                <thead>
                    <tr>
                        <th>訂單編號</th>
                        <th>狀態</th>
                        <th>總金額</th>
                        <th>日期</th>
                    </tr>
                </thead>
                <?php $colorDict = [
                '0' => 'btn btn-secondary',
                '1' => 'btn btn-warning',
                '2' => 'btn btn-info',
                '3' => 'btn btn-primary',
                '4' => 'btn btn-success',
                '5' => 'btn btn-secondary',
                '6' => 'btn btn-danger',
                ]; ?>
                <tbody>
                    @foreach ($myOrderList as $myOrder)
                    <tr>
                        <td class="align-middle">
                            <a href="/order/detail/{{$myOrder->order_numero}}"><button class="btn btn-primary">{{ $myOrder->order_numero }}</button></a>
                        </td>
                        <td class="align-middle">
                            <button class="{{ $colorDict[$myOrder->status_id] }}">
                                {{ $myOrder->status_word }}
                            </button>
                        </td>
                        <td class="align-middle">{{ $myOrder->total }}</td>
                        <td class="align-middle">{{ $myOrder->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
                {{-- <tfoot  class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <tr class="mr-2">
                                <td class="mr-2">
                                    
                                </td>
                            </tr>  
                        </div>        
                    </div>       
                </tfoot> --}}
            </table>
        </div>

        <div class="row p-2">
            @include('components.pagination')
        </div>
    </div>



@endsection
@section('js')
    <script>

    </script>
@endsection
