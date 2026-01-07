$(function() {
  console.log('compras.js cargado');
  let clienteId = null;
  let datosCliente = null;

  // Validar que el DNI solo acepte números y máximo 8 dígitos
  $('#dni').on('input', function() {
    // Eliminar cualquier carácter que no sea número
    this.value = this.value.replace(/[^0-9]/g, '');
    // Limitar a 8 caracteres
    if (this.value.length > 8) {
      this.value = this.value.slice(0, 8);
    }
  });

  function buildUrl(path) {
    if (typeof BASE_URL === 'undefined') return path;
    return BASE_URL.replace(/\/$/, '') + '/' + path.replace(/^\/+/, '');
  }
  
  // CSRF globals (from layout). If not available, we won't include token.
  let _csrfName = (typeof CSRF_TOKEN_NAME !== 'undefined') ? CSRF_TOKEN_NAME : null;
  let _csrfValue = (typeof CSRF_TOKEN_VALUE !== 'undefined') ? CSRF_TOKEN_VALUE : null;
  // Apply initial header for all AJAX requests if token available
  if (_csrfValue) {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': _csrfValue } });
  }
  function refreshCsrf() {
    if (!buildUrl || !_csrfName) return;
    $.get(buildUrl('csrf/token'), function (res) {
      if (res && res.csrf_token && res.csrf_hash) {
        _csrfName = res.csrf_token;
        _csrfValue = res.csrf_hash;
        // update global AJAX header so subsequent requests use the fresh token
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': _csrfValue } });
      }
    }, 'json').fail(function () {
      console.warn('No se pudo refresh token CSRF');
    });
  }

  // Función para buscar cliente (reutilizable)
  function buscarCliente() {
    const dni = $('#dni').val().trim();

    if (!dni) return;

    const dataBuscar = { dni };
    if (_csrfName) dataBuscar[_csrfName] = _csrfValue;

    const jq1 = $.post(buildUrl('clientes/buscar-dni'), dataBuscar, function (res) {

      if (res.success) {
        clienteId = res.cliente.id;
        datosCliente = res.cliente;

        $('#datosCliente').text(
          res.cliente.nombres + ' ' + res.cliente.apellidos
        );
        $('#puntosActuales').text(res.cliente.puntos_acumulados);
        $('#infoCliente').show();

      } else {
        Swal.fire({
          title: 'Cliente no encontrado',
          text: '¿Deseas registrarlo?',
          icon: 'question',
          showCancelButton: true
        }).then(r => {
          if (r.isConfirmed) {
            $('#numero_documento').val(dni);
            $('#modalCliente').modal('show');
          }
        });
      }

    }, 'json').fail(function (xhr, status, error) {
      console.error('Error en /clientes/buscar-dni:', status, error);
      Swal.fire('Error', 'No se pudo buscar el cliente. Revisa la consola.', 'error');
    }).always(function() { refreshCsrf(); });
  }

  // Event listener para el botón "Buscar"
  $('#buscarCliente').on('click', buscarCliente);

  // Event listener para presionar Enter en el input del DNI
  $('#dni').on('keypress', function (e) {
    if (e.which === 13 || e.keyCode === 13) { // Enter key
      e.preventDefault();
      buscarCliente();
    }
  });

  // Función para limpiar el formulario después de guardar
  function limpiarFormulario() {
    // Limpiar campo de monto
    $('#monto').val('');

    // Resetear variables de estado
    clienteId = null;
    datosCliente = null;

    // Ocultar sección de información del cliente
    $('#infoCliente').hide();
  }

  $('#guardarCompra').on('click', function () {
    const monto = $('#monto').val();

    // Validar que se haya seleccionado un cliente
    if (!clienteId) {
      Swal.fire('Error', 'Debe seleccionar un cliente', 'error');
      return;
    }

    if (!monto || monto <= 0) {
      Swal.fire('Error', 'Monto inválido', 'error');
      return;
    }

    const dataRegistrar = { cliente_id: clienteId, monto: monto };
    if (_csrfName) dataRegistrar[_csrfName] = _csrfValue;

    const jq2 = $.post(buildUrl('compras/registrar'), dataRegistrar, function (res) {

      if (!res.success) {
        Swal.fire('Error', res.msg || 'Error al registrar la compra', 'error');
        return;
      }

      // Actualiza puntos en pantalla
      $('#puntosActuales').text(
        parseInt($('#puntosActuales').text()) + res.puntos_generados
      );

      Swal.fire({
        title: 'Compra registrada',
        text: 'Puntos generados: ' + res.puntos_generados,
        icon: 'success',
        showCancelButton: true,
        confirmButtonText: 'Imprimir ticket',
        cancelButtonText: 'Cerrar'
      }).then(r => {
        if (r.isConfirmed) {
          window.open(
            buildUrl('compras/ticket/' + res.compra_id),
            '_blank'
          );
        }
        // Limpiar formulario después de cerrar la alerta
        limpiarFormulario();
      });

    }, 'json')
    .fail(function (xhr, status, error) {
      console.error('Error en /compras/registrar:', status, error);
      Swal.fire('Error', 'No se pudo registrar la compra.', 'error');
    })
    .always(function () {
      refreshCsrf();
    });
  });

  // Event listener para el botón "Imprimir"
  $('#imprimir').on('click', function () {
    if (!clienteId) {
      Swal.fire({
        title: 'Sin cliente',
        text: 'Debes buscar un cliente primero',
        icon: 'warning',
        confirmButtonText: 'Entendido'
      });
      return;
    }

    // Abre el ticket del cliente con sus puntos actuales (sin necesidad de compra_id)
    window.open(
      buildUrl('compras/ticket-cliente/' + clienteId),
      '_blank'
    );
  });



  /* codigo para registrar cliente */

  function abrirModalRegistro(dni) {
    $('#numero_documento').val(dni);
    $('#modalCliente').modal('show');
  }



  $('#formCliente').on('submit', function (e) {
    e.preventDefault();

    let formData = $(this).serialize();
    if (_csrfName) {
      formData += '&' + encodeURIComponent(_csrfName) + '=' + encodeURIComponent(_csrfValue);
    }

    const jq3 = $.post(buildUrl('clientes/guardar'), formData, function (res) {

      if (res.success) {
        clienteId = res.cliente_id;
        $('#modalCliente').modal('hide');

        Swal.fire('Registrado', 'Cliente creado correctamente', 'success');

         // 👇 VUELVE AL FLUJO DE COMPRA
        $('#datosCliente').text(
          $('input[name="nombres"]').val() + ' ' +
          $('input[name="apellidos"]').val()
        );
        $('#puntosActuales').text(0);
        $('#infoCliente').show();
      } else {
        Swal.fire('Error', res.msg, 'error');
      }

    }, 'json').fail(function (xhr, status, error) {
      console.error('Error en /clientes/guardar:', status, error);
      Swal.fire('Error', 'No se pudo guardar el cliente.', 'error');
    }).always(function() { refreshCsrf(); });
  });

});
