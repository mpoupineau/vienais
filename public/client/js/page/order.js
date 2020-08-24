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
    let totalVracVolume = 0;

    $('#quantity-info-details').html('');

    $(':input[name^=\'qty_\']').each((index, elem) => {
        const bottleId = $(elem).attr('name').substring(4);

        if ("bouteille" === $("input[name='type_" + bottleId + "']").val().toLowerCase()) {
            totalBottle += parseInt($(elem).val());
        }

        if ("magnum" === $("input[name='type_" + bottleId + "']").val().toLowerCase()) {
            totalMagnum += parseInt($(elem).val());
        }

        if (4 < $("input[name='volume_" + bottleId + "']").val()) {
            totalVracVolume  += parseInt($(elem).val()) * $("input[name='volume_" + bottleId + "']").val();
        }
    });

    const totalProduct = totalBottle + totalMagnum;
    const magnumModulo = totalMagnum % 3;
    const bottleModulo = totalBottle % 6;

    if ((12 <= (totalBottle + totalVracVolume) || 12 < totalVracVolume) && 0 === magnumModulo && 0 === bottleModulo) {
        updateDeliveryFees();
        $('#info-quantity').removeClass('fail-card');
        $('#info-quantity').addClass('success-card');
        $("#basket-validation-button").removeClass('basket-button-disabled');
        $("#basket-validation-button").addClass('basket-button');
    } else {
        hideDeliveryFees();
        $('#info-quantity').removeClass('success-card');
        $('#info-quantity').addClass('fail-card');
        $("#basket-validation-button").removeClass('basket-button');
        $("#basket-validation-button").addClass('basket-button-disabled');

        let detailsMessage = "";

        if (6 < totalBottle && 0 < magnumModulo) {
            const magnumLeft = 3 - magnumModulo;
            detailsMessage += "Il manque " + magnumLeft + " magnum(s) pour compléter le carton.<br>"
        }

        if (6 < totalProduct && 0 < bottleModulo) {
            const bottleLeft = 6 - bottleModulo;
            detailsMessage += "Il manque " + bottleLeft + " bouteille(s) pour compléter le carton.<br>"
        }
        $('#quantity-info-details').html(detailsMessage);
    }
}

/**
 * Update delivery Fees
 */
function updateDeliveryFees() {
    const bottles = [];
    $(':input[name^=\'qty_\']').each((index, elem) => {
        const bottleId = $(elem).attr('name').substring(4);
        bottles[bottleId] = $(elem).val();
    });

    $('.transport-fees').find('.basket-result').html('<div class="loader-wrapper" id="loader-1-xs-5"><div id="loader"></div><\div>');
    $('.total-price').find('.basket-result').html('<div class="loader-wrapper" id="loader-1-xs-5"><div id="loader"></div><\div>');
    $.ajax({
        url: Routing.generate('client_order_partial_deliveryfees'),
        type: "POST",
        data: {bottles:bottles},
        success: (data) => {
            const subTotal =  parseFloat($('.sub-total-price').find('.basket-result').text().slice(0, -1));
            const deliveryFees = data.deliveryFees;
            const total = deliveryFees + subTotal;
            $('.transport-fees').find('.basket-result').text(deliveryFees.toFixed(2) + " €");
            $('.total-price').find('.basket-result').text(total.toFixed(2) + " €");

        }
    });
}

function hideDeliveryFees() {
    $('.transport-fees').find('.basket-result').text("- €");
    $('.total-price').find('.basket-result').text("- €");

}

$("#basket-validation-button").click((elem) => {
    if ($("#basket-validation-button").hasClass('basket-button-disabled')) {
        elem.preventDefault();
    }
});


