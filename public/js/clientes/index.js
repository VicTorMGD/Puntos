$(document).ready(function () {
    if ($('#tablaClientes').length) {
        $('#tablaClientes').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            order: [[0, 'asc']],
            pageLength: 10
        });
    }
});

$(document).on('click', '.btnEliminar', function () {
    const id = $(this).data('id');

    Swal.fire({
        title: '¿Eliminar cliente?',
        text: 'Esta acción desactivará al cliente',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((r) => {
        if (r.isConfirmed) {
            $.ajax({
                url: `${BASE_URL}/clientes/${id}/delete`,
                type: 'POST',
                data: {
                    [CSRF_TOKEN_NAME]: CSRF_TOKEN_VALUE
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            text: response.msg || 'Cliente eliminado exitosamente',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.msg || 'No se pudo eliminar el cliente'
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error al eliminar:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al eliminar el cliente'
                    });
                }
            });
        }
    });
});
