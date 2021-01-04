<li>
    <a class="little-cart-btn" href="javascript:;">
        <i class="fa fa-shopping-cart little-cart-btn"></i>
        <span id="little-cart-count" class="little-cart-btn">0</span>
    </a>
</li>

<div class="cart-container">

    <div class="shopping-cart" style="display: none;">

        <!--start shopping-cart-header -->
        <div class="shopping-cart-header">
            <i class="fa fa-shopping-cart cart-icon"></i>
            <div class="shopping-cart-total">
                <span class="lighter-text">小計:</span>
                <span id="shopping-cart-total" class="main-color-text"></span>
            </div>
        </div>
        <!--end shopping-cart-header -->

        <ul class="shopping-cart-items">
            {{-- for loop items here --}}
        </ul>

        <a href="/cart" class="btn btn-primary">Checkout</a>
        
    </div>

</div>