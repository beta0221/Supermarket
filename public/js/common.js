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
            $('#shopping-cart-total').html('$' + res.subtotal);
            $('#little-cart-count').html(res.count);
            Object.keys(res.items).forEach(key => {
                let item = res.items[key];
                $('.shopping-cart-items').append(cartItem(item));
            });
        },
        error:function(error){
            flashMessage('系統錯誤。','danger');
            console.log(error);
        }
    });
}

function addToCart(sku,qty = 1){
    $.ajax({
        type: "POST",
        url: "/cart/add/" + sku,
        data: {
            qty:qty,
        },
        success: function (response) {
            flashMessage('成功加入購物車。');
            getCartItems();
        },
        error: function(error){
            flashMessage('系統錯誤。','danger');
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
            flashMessage('系統錯誤。','danger');
            console.log(error);
        }
    });
}

function flashMessage(body,type='success',header='訊息'){
    let alertType = 'alert-' + type;
    var cell = $('.message-stack .alert-example').clone();
    cell.find('.alert-heading').html(header);
    cell.find('span').html(body);
    cell.show().removeClass('alert-example').addClass(alertType).addClass('show').appendTo('.message-stack');
    setTimeout(function(){ 
        cell.alert('close');
     }, 1800);
}