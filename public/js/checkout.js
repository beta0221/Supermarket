jQuery(function(){
    
    
    $('#county').on('change',function(){
        let county = $(this).val();
        $('#city').val('');
        cities[county].forEach(city => {
            console.log(city.name);
            $('#city').append(`<option value="${city.name}">${city.name}</option>`);    
        });
    })


});
