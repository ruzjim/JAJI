$('#confirmCierreBtn').on('click', function () {

    let allFieldsFilled = true;

    $('.iFaltante').each(function () {
        if (!$(this).val()) {
            allFieldsFilled = false;
            return false; y
        }
    });

    if (!allFieldsFilled) {
        Swal.fire({
            title: 'Error',
            text: 'Todos los campos deben estar llenos antes de continuar.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
        return;
    }
    let total = 0;

   
    $('.montofaltante').each(function () {
        const value = parseFloat($(this).text() || $(this).val() || 0);
        if (!isNaN(value)) {
            total += value;
        }
    });

    if (total > 0) {
        Swal.fire({
            title: '¿Está seguro de continuar?',
            text: `El monto faltante es ${Math.abs(total)}. ¿Desea continuar?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                completarCierreCaja(total);
            } else {
                console.log('Operación cancelada.');
            }
        });
    } else if (total < 0) {
        Swal.fire({
            title: '¿Está seguro de continuar?',
            text: `El sobrante es de ${total}. ¿Desea continuar?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                completarCierreCaja(total);
            } else {
                console.log('Operación cancelada.');
            }
        });
    } else {
        completarCierreCaja(total);
    }
});

function completarCierreCaja(diferencia) {
    Swal.fire({
        title: 'Procesando...',
        text: 'Por favor, espere mientras se completa el cierre de caja.',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: 'CerrarCaja', 
        method: 'POST',
        data: {
            total: totalMetodosPago,
            diferencia: diferencia*-1,
            comentarios: $('#comentariosCierre').val() || 'N/A', 
            idVentas: idVentas 
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
        },
        success: function (response) {
            console.log(response);
            location.reload();
            // Swal.fire({
            //     title: 'Éxito',
            //     text: 'El cierre de caja se ha completado correctamente.',
            //     icon: 'success',
            //     confirmButtonText: 'Aceptar'
            // }).then(() => {
            //     // Optionally reload the page or redirect
            //     location.reload();
            // });
        },
        error: function (xhr, status, error) {
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al completar el cierre de caja. Intente nuevamente.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            console.error('Error:', error);
        }
    });
}

