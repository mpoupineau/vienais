$(() => {
    if (0 < $(':input[name^=\'qty_\']').length ) {
        let subTotal = 0;

        $(':input[name^=\'qty_\']').each((index, elem) => {
            const bottleId = $(elem).attr('name').substring(4);
            subTotal = subTotal + $(elem).val() * $("input[name='price_" + bottleId + "']").val();
        });

        $('.sub-total-price').find('.basket-result').text(subTotal.toFixed(2) + " €");
        $('.total-price').find('.basket-result').text(subTotal.toFixed(2) + " €");
    }
});

$(':input[name^=\'qty_\']').change(() => {
    let subTotal = 0;
    const bottles = [];

    $(':input[name^=\'qty_\']').each((index, elem) => {
        const bottleId = $(elem).attr('name').substring(4);
        bottles[bottleId] = $(elem).val();
        subTotal = subTotal + $(elem).val() * $("input[name='price_" +bottleId+ "']").val();
    });

    $('.sub-total-price').find('.basket-result').text(subTotal.toFixed(2) + " €");
    $('.total-price').find('.basket-result').text(subTotal.toFixed(2) + " €");

    $.ajax({
        url: Routing.generate('client_wine_partial_bottle_update'),
        type: "POST",
        data: {bottles:bottles},
        success: () => {
        }
    });
});

/************* Delivery **************************/
$('#show-basket-button').click(() => {
    if ($('#basket-summary').css("display") === "none") {
        $('#basket-summary').show('fast');
        $('#show-basket-button').html('<i class="fa fa-minus"></i>')
    } else {
        $('#basket-summary').hide('fast');
        $('#show-basket-button').html('<i class="fa fa-plus"></i>')
    }
});

/************* Delivery **************************/
$('#show-delivery-button').click(() => {
    if ($('#delivery-summary').css("display") === "none") {
        $('#delivery-summary').show('fast');
        $('#show-delivery-button').html('<i class="fa fa-minus"></i>')
    } else {
        $('#delivery-summary').hide('fast');
        $('#show-delivery-button').html('<i class="fa fa-plus"></i>')
    }
});

