@extends('layouts.main')
    @section('title','購買成功')
        @section('css')
        @endsection
    @section('content') 
        @include('components.breadcrumb')

        <div class="container">
            <div class="row">
                <div class="col-md-12 mt-3" style="text-align: center">
                    <h3>訂單細節</h3>
                    {{$orderProduct}}
                </div>
            </div>
        </div>


    @endsection