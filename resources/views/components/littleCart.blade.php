<div class="cart-container">

    <div class="shopping-cart" style="display: none;">

        <!--start shopping-cart-header -->
        <div class="shopping-cart-header">
            <i class="fa fa-shopping-cart cart-icon"></i>
            <div class="shopping-cart-total">
                <span class="lighter-text">Total:</span>
                <span class="main-color-text">{{Cart::total()}}</span>
            </div>
        </div>
        <!--end shopping-cart-header -->

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