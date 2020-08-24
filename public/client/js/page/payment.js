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

/************* Payment details ***********************************/
$('#show-card-payment-info-button').click(() => {
    if ($('#card-payment-info').css("display") === "none") {
        $('#card-payment-info').show('fast');
        $('#check-info').hide('fast');
        $('#show-card-payment-info-button').removeClass('basket-button-unselected');
        $('#show-card-payment-info-button').addClass('basket-button');
        $('#show-check-info-button').addClass('basket-button-unselected');
        $('#show-check-info-button').removeClass('basket-button');
        $('#div-payment-button').find('a').html('Payer par carte');
        $('#div-payment-button').find('a').attr('href', Routing.generate('client_order_payment_choice', {
            'orderReference': $('#order-reference').val(),
            'paymentType': 'card'
        }));
    }
});

$('#show-check-info-button').click(() => {
    if ($('#check-info').css("display") === "none") {
        $('#check-info').show('fast');
        $('#card-payment-info').hide('fast');
        $('#show-check-info-button').removeClass('basket-button-unselected');
        $('#show-check-info-button').addClass('basket-button');
        $('#show-card-payment-info-button').addClass('basket-button-unselected');
        $('#show-card-payment-info-button').removeClass('basket-button');
        $('#div-payment-button').find('a').html('Payer par chèque');
        $('#div-payment-button').find('a').attr('href', Routing.generate('client_order_payment_choice', {
            'orderReference': $('#order-reference').val(),
            'paymentType': 'check'
        }));
    }
});