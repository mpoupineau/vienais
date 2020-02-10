function getCuveeDetails(cuveeId) {
    $.ajax({
        url: Routing.generate('product_partial_cuvee_details', {
            'cuveeId': cuveeId
        }),
        type: "GET",
        success: (data) => {
            $("#modalCuvee").html(data);
            $(".modalLayout").modal('show');
        },
        error: (results, status, error) => {
            $("#modalLayout").modal('show');
        }
    })
}

$('#modalCuvee').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);
    const cuveeId = button.data('id');
    $.ajax({
        url: Routing.generate('product_partial_cuvee_details', {
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