@extends('layouts.main')
@section('title', '購買成功')
@section('css')
@endsection
@section('content')
    @include('components.breadcrumb')


    <div class="container">
        <div class="row">
            <table class="table table-hover" style="margin: 2rem">
                <thead>
                    <tr>
                        <th style="border: 0px">
                            <h4>{{ $user->name }} 的訂單 <h4>
                        </th>
                    </tr>
                    <tr>
                        <th>訂單編號</th>
                        <th>狀態</th>
                        <th>總金額</th>
                        <th>下單日期</th>
                        <th>詳細內容</th>
                    </tr>
                </thead>
                <?php $colorDict = [
                '0' => 'btn btn-error',
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
                        <td class="align-middle">{{ $myOrder->order_numero }}</td>
                        <td class="align-middle">
                            <button class="{{ $colorDict[$myOrder->status_id] }}">
                                {{ $myOrder->status_word }}
                            </button>
                        </td>
                        <td class="align-middle">{{ $myOrder->total }}</td>
                        <td class="align-middle">{{ $myOrder->created_at }}</td>
                        <td>
                            <a href="/order/myOrderDetail/{{$myOrder->id}}"><button class="btn btn-primary">詳細</button></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot  class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <tr class="mr-2">
                                <td class="mr-2">
                                    @include('components.pagination')
                                </td>
                            </tr>  
                        </div>        
                    </div>       
                </tfoot>
            </table>
        </div>
    </div>



@endsection
@section('js')
    <script>

    </script>
@endsection
