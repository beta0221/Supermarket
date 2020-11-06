jQuery(function(){
    let csrf_token = document.head.querySelector('meta[name="csrf-token"]').content;
    $.ajaxSetup({
        headers: { 
            "X-CSRF-TOKEN": csrf_token,
        }
    });
});

function addToCart(sku){
    $.ajax({
        type: "POST",
        url: "/cart/add/" + sku,
        data: null,
        success: function (response) {
            console.log(response);
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