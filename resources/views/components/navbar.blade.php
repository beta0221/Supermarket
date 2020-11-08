<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="img/logo.png" alt=""></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
            <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
        </ul>
        <div class="header__cart__price">item: <span>$150.00</span></div>
    </div>
    <div class="humberger__menu__widget">
        <div class="header__top__right__language">
            <img src="img/language.png" alt="">
            <div>English</div>
            <span class="arrow_carrot-down"></span>
            <ul>
                <li><a href="#">Spanis</a></li>
                <li><a href="#">English</a></li>
            </ul>
        </div>
        <div class="header__top__right__auth">
            @auth
            <a href="/home"><i class="fa fa-user"></i>{{auth()->user()->name}}</a>
            @endauth
            @guest
            <a href="/login"><i class="fa fa-user"></i> Login</a>    
            @endguest
        </div>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="{{(Request::is('/'))?'active':''}}"><a href="/">Home</a></li>
            <li class="{{(Request::is('shop'))?'active':''}}"><a href="/shop">Shop</a></li>
            <li><a href="#">Pages</a>
                <ul class="header__menu__dropdown">
                    <li><a href="./shop-details.html">Shop Details</a></li>
                    <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                    <li><a href="./checkout.html">Check Out</a></li>
                    <li><a href="./blog-details.html">Blog Details</a></li>
                </ul>
            </li>
            <li><a href="./blog.html">訂購相關</a></li>
            <li><a href="./contact.html">連絡我們</a></li>
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
                            <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                            <li>Free Shipping for all Order of $99</li>
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
                        <div class="header__top__right__language">
                            <img src="img/language.png" alt="">
                            <div>English</div>
                            <span class="arrow_carrot-down"></span>
                            <ul>
                                <li><a href="#">Spanis</a></li>
                                <li><a href="#">English</a></li>
                            </ul>
                        </div>
                        <div class="header__top__right__auth">
                            @auth
                            <a href="/home"><i class="fa fa-user"></i>{{auth()->user()->name}}</a>
                            @endauth
                            @guest
                            <a href="/login"><i class="fa fa-user"></i> Login</a>    
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
                    <a href="./index.html"><img src="img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <li class="{{(Request::is('/'))?'active':''}}"><a href="/">Home</a></li>
                        <li class="{{(Request::is('shop'))?'active':''}}"><a href="/shop">Shop</a></li>
                        <li><a href="#">Pages</a></li>
                        <li><a href="./blog.html">Blog</a></li>
                        <li><a href="./contact.html">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>                      
                    <li><a href="#" id="cart"><i class="fa fa-shopping-cart"></i><span>{{Cart::content()->count()}}</span></a></li>
                <div class="cart-container">
                    <div class="shopping-cart">
                        <div class="shopping-cart-header">
                          <i class="fa fa-shopping-cart cart-icon"></i>
                          <div class="shopping-cart-total">
                            <span class="lighter-text">Total:</span>
                            <span class="main-color-text">{{Cart::total()}}</span>
                          </div>
                        </div> <!--end shopping-cart-header -->
                        
                            <ul class="shopping-cart-items">
                                @foreach (Cart::content() as $row)
                                <ul class="shopping-cart-items">
                                   <li class="clearfix">
                                     <img src="{{$row->model->getFirstImageUrl()}}" alt="item1" />
                                     <span class="item-name">{{$row->name}}</span>
                                     <span class="item-price">${{$row->price}}</span>
                                     <span class="item-quantity">Quantity: {{$row->qty}}</span>
                                   </li>
                                 </ul>
                               @endforeach
                            </ul>
                        
                            <a href="#" class="btn btn-primary">Checkout</a>
                          </div>
                </div>
                    
                    </ul>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->

