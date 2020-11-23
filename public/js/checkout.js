jQuery(function(){
    
    
    $('#county').on('change',function(){
        let county = $(this).val();
        $('#postal_code').val('');
        $('#postal_code').empty();
        $('#postal_code').append(`<option value="">地區</option>`);
        cities[county].forEach(city => {
            $('#postal_code').append(`<option value="${city.zip}">${city.name}</option>`);
        });
    });

    $('#carrier_id').on('change',function(){
        let carrier_id = $(this).val();
        $('#payment_id').val('');
        $('#payment_id').empty();
        $('#payment_id').append(`<option value="">付款方式</option>`);  
        payments[carrier_id].forEach(payment => {
            $('#payment_id').append(`<option value="${payment.id}">${payment.name}</option>`);    
        });
    });


});
