@extends('layouts.main')

@section('title','聯絡我們')

@section('css')

@endsection

@section('content')

    @include('components.breadcrumb',['crumbs'=>[
        ['url'=>null,'name'=>'聯絡我們']
    ]])


    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_phone"></span>
                        <h4>客服電話</h4>
                        <p>0800-552-999</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_pin_alt"></span>
                        <h4>公司地址</h4>
                        <p>桃園市桃園區大有路59號3樓</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_clock_alt"></span>
                        <h4>營業時間</h4>
                        <p>9:00 am ~ 17:30 pm</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_mail_alt"></span>
                        <h4>Email</h4>
                        <p>kingpork80390254@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- Contact Form Begin -->
    <div class="contact-form spad mt-0 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact__form__title">
                        <h2>聯絡我們</h2>
                    </div>
                </div>
            </div>




            @if (Session::has('error'))
            <?php $error = Session::get('error'); ?>
            <p class="alert alert-danger">
                @foreach($error->all() as $message)
                {{$message}}<br>
                @endforeach
            </p>
            @endif

            @if (Session::has('success'))
            <p class="alert alert-success">{{ Session::get('success') }}</p>
            @endif

            <?php $errors = Session::get('error'); ?>
            <form action="/contact" method="POST">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <input type="text" placeholder="姓名" name="name">
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <input type="text" placeholder="Email" name="email">
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <input type="text" placeholder="主旨" name="title">
                    </div>
                    <div class="col-lg-12 text-center">
                        <textarea placeholder="訊息..." name="message"></textarea>
                        <button type="submit" class="site-btn">確認送出</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Contact Form End -->


    <!-- Map Begin -->
    <div class="map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3615.8630138224594!2d121.3224238588966!3d25.00477030090872!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34681e5a371e6323%3A0x3192af8956be9763!2zMzMw5qGD5ZyS5biC5qGD5ZyS5Y2A5aSn5pyJ6LevNTnomZ8!5e0!3m2!1szh-TW!2stw!4v1528712582756"
            height="500" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        {{-- <div class="map-inside">
            <i class="icon_pin"></i>
            <div class="inside-widget">
                <h4>New York</h4>
                <ul>
                    <li>Phone: +12-345-6789</li>
                    <li>Add: 16 Creek Ave. Farmingdale, NY</li>
                </ul>
            </div>
        </div> --}}
    </div>
    <!-- Map End -->



@endsection

@section('js')

@endsection