/************* Basket details **************************/
$('#show-basket-button').click(() => {
    if ($('#basket-summary').css("display") === "none") {
        $('#basket-summary').show('fast');
        $('#show-basket-button').html('<i class="fa fa-minus"></i>')
    } else {
        $('#basket-summary').hide('fast');
        $('#show-basket-button').html('<i class="fa fa-plus"></i>')
    }
});


/************* Delivery Address details **************************/
$('#show-delivery-button').click(() => {
    if ($('#delivery-summary').css("display") === "none") {
        $('#delivery-summary').show('fast');
        $('#show-delivery-button').html('<i class="fa fa-minus"></i>')
    } else {
        $('#delivery-summary').hide('fast');
        $('#show-delivery-button').html('<i class="fa fa-plus"></i>')
    }
});