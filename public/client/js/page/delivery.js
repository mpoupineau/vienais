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