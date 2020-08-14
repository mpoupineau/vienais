$(() => {
    updatePrice();
    checkQuantity();
});

$(':input[name^=\'qty_\']').change(() => {
    updatePrice();
    checkQuantity();
    const bottles = [];

    $(':input[name^=\'qty_\']').each((index, elem) => {
        const bottleId = $(elem).attr('name').substring(4);
        bottles[bottleId] = $(elem).val();
    });

    $.ajax({
        url: Routing.generate('client_wine_partial_bottle_update'),
        type: "POST",
        data: {bottles:bottles},
        success: () => {
        }
    });
});

/**
 * Update basket price
 */
function updatePrice() {
    if (0 < $(':input[name^=\'qty_\']').length ) {
        let subTotal = 0;

        $(':input[name^=\'qty_\']').each((index, elem) => {
            const bottleId = $(elem).attr('name').substring(4);
            subTotal = subTotal + $(elem).val() * $("input[name='price_" + bottleId + "']").val();
        });

        $('.sub-total-price').find('.basket-result').text(subTotal.toFixed(2) + " €");
        $('.total-price').find('.basket-result').text(subTotal.toFixed(2) + " €");
    }
}

/**
 * Check product quantity (bottles & magnum)
 * Set style and messages
 *
 */
function checkQuantity() {
    let totalBottle = 0;
    let totalMagnum = 0;

    $('#quantity-info-details').html('');

    $(':input[name^=\'qty_\']').each((index, elem) => {
        const bottleId = $(elem).attr('name').substring(4);

        if ("bouteille" === $("input[name='type_" + bottleId + "']").val().toLowerCase()) {
            totalBottle += parseInt($(elem).val());
        }

        if ("magnum" === $("input[name='type_" + bottleId + "']").val().toLowerCase()) {
            totalMagnum += parseInt($(elem).val());
        }
    });

    const totalProduct = totalBottle + totalMagnum;
    const magnumModulo = totalMagnum % 3;
    const bottleModulo = totalBottle % 6;

    if (0 < totalProduct && 0 === magnumModulo && 0 === bottleModulo) {
        $('#info-quantity').removeClass('fail-card');
        $('#info-quantity').addClass('success-card');
        $("#basket-validation-button").removeClass('basket-button-disabled');
        $("#basket-validation-button").addClass('basket-button');
    } else {
        $('#info-quantity').removeClass('success-card');
        $('#info-quantity').addClass('fail-card');
        $("#basket-validation-button").removeClass('basket-button');
        $("#basket-validation-button").addClass('basket-button-disabled');

        let detailsMessage = "";

        if (0 < magnumModulo) {
            const magnumLeft = 3 - magnumModulo;
            detailsMessage += "Il manque " + magnumLeft + " magnum(s) pour compléter le carton.<br>"
        }

        if (0 < bottleModulo) {
            const bottleLeft = 6 - bottleModulo;
            detailsMessage += "Il manque " + bottleLeft + " bouteille(s) pour compléter le carton.<br>"
        }
        $('#quantity-info-details').html(detailsMessage);
    }
}

$("#basket-validation-button").click((elem) => {
    if ($("#basket-validation-button").hasClass('basket-button-disabled')) {
        elem.preventDefault();
    }
});


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
        $('#div-payment-button').find('a').attr('href', Routing.generate('client_order_summary', {
            'bottleId': 1,
            'type': 'card'
        }));
    }/* else {
        $('#card-payment-info').hide('fast');
        $('#show-card-payment-info-button').addClass('basket-button-unselected');
        $('#show-card-payment-info-button').removeClass('basket-button');
    }*/
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
        $('#div-payment-button').find('a').attr('href', Routing.generate('client_order_summary', {
            'bottleId': 1,
            'type': 'check'
        }));
    }/* else {
        $('#check-info').hide('fast');
        $('#show-check-info-button').addClass('basket-button-unselected');
        $('#show-check-info-button').removeClass('basket-button');
    }*/
});