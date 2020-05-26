$('#modalCuvee').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);
    const cuveeId = button.data('id');
    $.ajax({
        url: Routing.generate('client_wine_partial_cuvee_details', {
            'cuveeId': cuveeId
        }),
        type: "GET",
        success: (data) => {
            const modal = $(this);
            modal.find('.modal-body-cuvee').html(data);
        },
        error: (results, status, error) => {
            $("#modalLayout").modal('show');
        }
    })
});

$('#modalVintage').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);
    const vintageId = button.data('id');
    $.ajax({
        url: Routing.generate('client_wine_partial_vintage_details', {
            'vintageId': vintageId
        }),
        type: "GET",
        success: (data) => {
            const modal = $(this);
            modal.find('.modal-body-vintage').html(data);
        },
        error: (results, status, error) => {
            $("#modalLayout").modal('show');
        }
    })
});