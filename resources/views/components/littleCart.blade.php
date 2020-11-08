<nav>
    <div class="container">
      <ul class="navbar-left">
        <li><a href="#">Home</a></li>
        <li><a href="#about">About</a></li>
      </ul> <!--end navbar-left -->
  
      <ul class="navbar-right">
        <li><a href="#" id="cart"><i class="fa fa-shopping-cart"></i> Cart <span class="badge">3</span></a></li>
      </ul> <!--end navbar-right -->
    </div> <!--end container -->
  </nav>
  
  
  <div class="container">
    <div class="shopping-cart">
      <div class="shopping-cart-header">
        <i class="fa fa-shopping-cart cart-icon"></i><span class="badge">3</span>
        <div class="shopping-cart-total">
          <span class="lighter-text">Total:</span>
          <span class="main-color-text">$2,229.97</span>
        </div>
      </div> <!--end shopping-cart-header -->
  
      <ul class="shopping-cart-items">
        <li class="clearfix">
          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/cart-item1.jpg" alt="item1" />
          <span class="item-name">Sony DSC-RX100M III</span>
          <span class="item-price">$849.99</span>
          <span class="item-quantity">Quantity: 01</span>
        </li>
      </ul>
  
      <a href="#" class="button">Checkout</a>
    </div> <!--end shopping-cart -->
  </div> <!--end container -->



  @foreach (Cart::content() as $row)
  <ul class="shopping-cart-items">
     <li class="clearfix">
       <img src="{{$row->model->getFirstImageUrl()}}" alt="item1" />
       <span class="item-name">{{$row->name}}</span>
       <span class="item-price">${{$row->price}}</span>
       <span class="item-quantity">Quantity: {{$row->rowId}}</span>
     </li>
   </ul>
 @endforeach