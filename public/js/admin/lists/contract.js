
const  deleteEntry = (button)  => {
    const route = $(button).data('route');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    swal({
        title: "¿Estás seguro?",
        text: "¡No podrás recuperar este contrato!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: route,
                type: 'DELETE',
                data: {
                    _token: csrfToken
                },
                success: function(result) {
                    // Manejar el éxito, por ejemplo, refrescar la página o eliminar la entrada del DOM
                    swal("¡Contrato eliminado!", {
                        icon: "success",
                    }).then(() => {
                        window.location.reload();
                    });
                },
                error: function(result) {
                    // Manejar el error
                    swal("Error al eliminar el contrato", {
                        icon: "error",
                    });
                }
            });
        }
    });
}

