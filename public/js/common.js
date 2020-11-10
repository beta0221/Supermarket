jQuery(function(){
    let csrf_token = document.head.querySelector('meta[name="csrf-token"]').content;
    $.ajaxSetup({
        headers: { 
            "X-CSRF-TOKEN": csrf_token,
        }
    });
    
    /** 小購物車顯示 */
    $('body').on('click',function(event){
        if($(event.target).hasClass('little-cart-btn')){
            $(".shopping-cart").toggle();
            return;
        }
        $(".shopping-cart").hide();
    });

    /**載入購物車 */
    getCartItems();
});

function getCartItems(){
    $('.shopping-cart-items').empty();
    $.ajax({
        type: "GET",
        url: "/cart/getItems",
        dataType: "json",
        success: function (res) {
            $('#shopping-cart-total').html('$' + res.total);
            $('#little-cart-count').html(res.count);
            Object.keys(res.items).forEach(key => {
                let item = res.items[key];
                $('.shopping-cart-items').append(cartItem(item));
            });
        },
        error:function(error){
            console.log(error);
        }
    });
}

function addToCart(sku){
    $.ajax({
        type: "POST",
        url: "/cart/add/" + sku,
        data: null,
        success: function (response) {
            getCartItems();
        },
        error: function(error){
            console.log(error);
        }
    });
}

function deleteFromCart(sku){
    $.ajax({
        type: "POST",
        url: "/cart/delete/" + sku,
        data: {'_method':'DELETE'},
        success: function (response) {
            window.location.reload();
        },
        error: function(error){
            console.log(error);
        }
    });
}