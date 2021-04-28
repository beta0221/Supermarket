<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="img/logo.png" alt=""></a>
    </div>
    {{-- <div class="humberger__menu__cart">
        <ul>
            <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
            <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
        </ul>
        <div class="header__cart__price">item: <span>$150.00</span></div>
    </div> --}}
    <div class="humberger__menu__widget">
        {{-- <div class="header__top__right__language">
            <img src="img/language.png" alt="">
            <div>English</div>
            <span class="arrow_carrot-down"></span>
            <ul>
                <li><a href="#">Spanis</a></li>
                <li><a href="#">English</a></li>
            </ul>
        </div> --}}
        <div class="header__top__right__auth">
            @auth
                <a href="/home"><i class="fa fa-user"></i>{{ auth()->user()->name }}</a>
            @endauth
            @guest
                <a href="/login"><i class="fa fa-user"></i> 登入</a>
            @endguest
        </div>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="/">首頁</a></li>
            <li class="{{ Request::is('shop') ? 'active' : '' }}"><a href="/shop">商品</a></li>
            <li><a href="https://blog.kingpork.com.tw" target="_blank">金園廚房</a></li>
            <li><a href="./blog.html">訂購相關</a></li>
            <li class="{{ Request::is('contact') ? 'active' : '' }}"><a href="/contact">連絡我們</a></li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-pinterest-p"></i></a>
    </div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
            <li>Free Shipping for all Order of $99</li>
        </ul>
    </div>
</div>
<!-- Humberger End -->

<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i> kingpork80390254@gmail.com</li>
                            {{-- <li>Free Shipping for all Order of $99</li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-pinterest-p"></i></a>
                        </div>
                        {{-- <div class="header__top__right__language">
                            <img src="img/language.png" alt="">
                            <div>English</div>
                            <span class="arrow_carrot-down"></span>
                            <ul>
                                <li><a href="#">Spanis</a></li>
                                <li><a href="#">English</a></li>
                            </ul>
                        </div> --}}
                        <div class="header__top__right__language">
                            @auth
                                <div> <a href="/shop"><i class="fa fa-user"></i>{{ auth()->user()->name }}</a></div>
                                <span class="arrow_carrot-down"></span>
                                <ul>
                                    <li><a href="/order/myOrder" >我的訂單</a></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-light">登出</button>
                                        </form>
                                    </li>
                                </ul>
                            @endauth
                            @guest
                                <a href="/login"><i class="fa fa-user"></i> 登入</a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="/"><img style="max-width: 120px;max-height:80px" src="img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="/">首頁</a></li>
                        <li class="{{ Request::is('shop') ? 'active' : '' }}"><a href="/shop">商品</a></li>
                        <li><a href="https://blog.kingpork.com.tw" target="_blank">金園廚房</a></li>
                        <li><a href="./blog.html">訂購相關</a></li>
                        <li class="{{ Request::is('contact') ? 'active' : '' }}"><a href="/contact">連絡我們</a></li>
                    </ul>
                </nav>
            </div>


        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
    
</header>
<!-- Header Section End -->

<!-- Float Header Cart Begin -->
@include('components.littleCart')
<!-- Float Header Cart End -->
