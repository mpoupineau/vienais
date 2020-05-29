$('#modalCuvee').on('show.bs.modal', function (event) {
    const modal = $(this);
    modal.find('.modal-body-cuvee').html('<div class="loader-wrapper" id="loader-1-s-5"><div id="loader"></div><\div>');
    const button = $(event.relatedTarget);
    const cuveeId = button.data('id');
    $.ajax({
        url: Routing.generate('client_wine_partial_cuvee_details', {
            'cuveeId': cuveeId
        }),
        type: "GET",
        success: (data) => {
            modal.find('.modal-body-cuvee').html(data);
        },
        error: (results, status, error) => {
            modal.find('.modal-body-cuvee').html('Une erreur est survenue');
        }
    })
});

$('#modalVintage').on('show.bs.modal', function (event) {
    const modal = $(this);
    modal.find('.modal-body-vintage').html('<div class="loader-wrapper" id="loader-1-s-5"><div id="loader"></div><\div>');
    const button = $(event.relatedTarget);
    const vintageId = button.data('id');
    $.ajax({
        url: Routing.generate('client_wine_partial_vintage_details', {
            'vintageId': vintageId
        }),
        type: "GET",
        success: (data) => {
            modal.find('.modal-body-vintage').html(data);
        },
        error: (results, status, error) => {
            modal.find('.modal-body-vintage').html('Une erreur est survenue');
        }
    })
});