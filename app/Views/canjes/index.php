<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
  .canjes-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
  }

  .canjes-card-header {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .canjes-card-header h3 {
    margin: 0;
    font-size: 1.35rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
  }

  .canjes-card-body {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
    padding: 20px 22px 24px;
  }

  .canjes-form-label {
    font-weight: 600;
    color: #1A6BA8;
  }

  .canjes-input {
    border-radius: 12px;
    border: 2px solid #4A9DD9;
    transition: all 0.2s ease;
  }

  .canjes-input:focus {
    border-color: #1A6BA8;
    box-shadow: 0 0 0 4px rgba(26, 107, 168, 0.12);
  }

  .btn-buscar-canje {
    background: linear-gradient(90deg, #ff6b35 0%, #ffa500 100%);
    border: none;
    color: #ffffff;
    font-weight: 600;
    border-radius: 50px;
    padding: 12px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    letter-spacing: 0.5px;
  }

  .btn-buscar-canje:hover {
    background: linear-gradient(90deg, #ff7a45 0%, #ffb319 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 107, 53, 0.3);
    color: #ffffff;
  }

  .info-cliente-box {
    background-color: #ffffff;
    border-radius: 14px;
    padding: 16px 18px 18px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    border: 1px solid #C8E0F0;
    margin-top: 15px;
  }

  .info-cliente-box p {
    margin-bottom: 6px;
  }

  .campania-item-card {
    border-radius: 12px;
    margin-bottom: 15px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .campania-item-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
  }

  .btn-canjear-item {
    background: linear-gradient(90deg, #ff6b35 0%, #ffa500 100%);
    border: none;
    color: #ffffff;
    font-weight: 600;
    border-radius: 50px;
    padding: 6px 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    letter-spacing: 0.5px;
    font-size: 0.85rem;
  }

  .btn-canjear-item:hover {
    background: linear-gradient(90deg, #ff7a45 0%, #ffb319 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 107, 53, 0.3);
    color: #ffffff;
  }

  .btn-ajustar-item {
    background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 50px;
    padding: 6px 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    font-size: 0.85rem;
  }

  .btn-ajustar-item:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 193, 7, 0.3);
    color: #fff;
  }

  .modal-header-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: #fff;
  }

  .modal-header-warning {
    background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
    color: #fff;
  }

  .btn-confirmar-canje {
    background: linear-gradient(90deg, #ff6b35 0%, #ffa500 100%);
    border: none;
    color: #ffffff;
    font-weight: 600;
    border-radius: 50px;
    padding: 10px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    letter-spacing: 0.5px;
  }

  .btn-confirmar-canje:hover {
    background: linear-gradient(90deg, #ff7a45 0%, #ffb319 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 107, 53, 0.3);
    color: #ffffff;
  }

  .btn-confirmar-ajuste {
    background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 50px;
    padding: 10px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
  }

  .btn-confirmar-ajuste:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 193, 7, 0.3);
    color: #fff;
  }

  .btn-cancelar-modal {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 50px;
    padding: 10px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
  }

  .btn-cancelar-modal:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(108, 117, 125, 0.3);
    color: #fff;
  }

  .alert-warning-custom {
    background: linear-gradient(135deg, #fff3cd 0%, #ffffff 100%);
    border-left: 4px solid #ffc107;
    border-radius: 10px;
    color: #856404;
  }

  .alert-info-custom {
    background: linear-gradient(135deg, #D4E8F5 0%, #ffffff 100%);
    border-left: 4px solid #1A6BA8;
    border-radius: 10px;
    color: #1A6BA8;
  }

  .canjes-image-col {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 15px;
    margin-top: 15px;
  }

  .canjes-image-col img {
    max-width: 100%;
    max-height: 220px;
    object-fit: contain;
    filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.1));
  }

  /* Responsive adjustments */
  @media (max-width: 991.98px) {
    .canjes-card-header {
      padding: 14px 18px;
    }
    .canjes-card-header h3 {
      font-size: 1.2rem;
    }
  }

  @media (max-width: 767.98px) {
    .canjes-card-body {
      padding: 16px 18px;
    }
    .canjes-image-col {
      margin-top: 10px;
    }
    .canjes-image-col img {
      max-height: 150px;
    }
    .campania-item-card .card-body {
      padding: 12px 15px;
    }
    .campania-item-card h5 {
      font-size: 1rem;
    }
    .btn-canjear-item,
    .btn-ajustar-item {
      width: 100%;
      margin-bottom: 5px;
    }
    .info-cliente-box {
      padding: 14px 16px;
    }
  }

  @media (max-width: 575.98px) {
    .canjes-card-header h3 {
      font-size: 1.1rem;
    }
    .canjes-card-body {
      padding: 14px 15px;
    }
    .canjes-image-col {
      display: none;
    }
    .btn-buscar-canje {
      width: 100%;
    }
    .modal-dialog {
      margin: 10px;
    }
  }
</style>

<div class="card canjes-card">
  <div class="canjes-card-header">
    <h3><i class="fas fa-exchange-alt mr-2"></i>Canje de Puntos</h3>
  </div>

  <div class="canjes-card-body">
    <?php if (!$campaniaActiva): ?>
    <div class="alert alert-warning-custom mb-3">
      <i class="fas fa-exclamation-triangle"></i>
      <strong>Atención:</strong> No hay campaña activa. Los canjes solo pueden realizarse sobre puntos existentes.
    </div>
    <?php endif; ?>

    <div class="row g-4">
      <!-- Panel de búsqueda -->
      <div class="col-12 col-md-5 col-lg-4">
        <div class="form-group">
          <label class="canjes-form-label" for="documento">DNI del Cliente</label>
          <input type="text" class="form-control canjes-input" id="documento"
                 placeholder="Ingrese DNI (8 dígitos)" maxlength="8" autofocus>
        </div>

        <button class="btn btn-buscar-canje mb-3" type="button" id="btnBuscar">
          <i class="fas fa-search mr-1"></i> Buscar
        </button>

        <!-- Info del cliente -->
        <div id="clienteInfo" class="info-cliente-box" style="display: none;">
          <h5 class="mb-2" style="color: #1A6BA8; font-weight: 600;"><i class="fas fa-user mr-2"></i>Cliente Encontrado</h5>
          <h4 id="clienteNombre" class="mb-2" style="color: #333;"></h4>
          <p class="mb-1"><strong style="color: #1A6BA8;">DNI:</strong> <span id="clienteDni"></span></p>
          <p class="mb-0">
            <strong style="color: #1A6BA8;">Total Puntos:</strong>
            <span id="clienteTotalPuntos" class="badge badge-success" style="font-size: 1.2em; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);"></span>
          </p>
          <input type="hidden" id="clienteId" value="">
        </div>

        <!-- Imagen decorativa -->
        <div class="canjes-image-col d-none d-md-flex">
          <img src="<?= base_url('assets/img/farmaceutica2.png') ?>" alt="Ilustración de canjes">
        </div>
      </div>

      <!-- Panel de puntos por campaña -->
      <div class="col-12 col-md-7 col-lg-8">
        <div id="panelPuntos" style="display: none;">
          <h5 class="mb-3" style="color: #1A6BA8; font-weight: 600;"><i class="fas fa-coins mr-2"></i>Puntos por Campaña</h5>
          <div id="listaPuntosCampania">
            <!-- Se llena dinámicamente -->
          </div>
        </div>

        <!-- Sin puntos -->
        <div id="sinPuntos" class="alert alert-info-custom" style="display: none;">
          <i class="fas fa-info-circle"></i> Este cliente no tiene puntos disponibles para canjear.
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal para canjear puntos -->
<div class="modal fade" id="modalCanje" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header modal-header-success">
        <h5 class="modal-title"><i class="fas fa-exchange-alt mr-2"></i>Canjear Puntos</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong style="color: #1A6BA8;">Campaña:</strong> <span id="canjeNombreCampania"></span></p>
        <p><strong style="color: #1A6BA8;">Puntos disponibles:</strong> <span id="canjePuntosDisponibles" class="badge badge-success" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);"></span></p>

        <div class="form-group">
          <label for="puntosACanjear" style="color: #1A6BA8; font-weight: 600;">Puntos a canjear <span class="text-danger">*</span></label>
          <input type="number" class="form-control" id="puntosACanjear" min="1" required style="border: 1px solid #4A9DD9; border-radius: 8px;">
          <small class="form-text text-muted">Ingrese la cantidad de puntos a descontar</small>
        </div>

        <div class="form-group">
          <label for="observacionCanje" style="color: #1A6BA8; font-weight: 600;">Observación</label>
          <textarea class="form-control" id="observacionCanje" rows="2"
                    placeholder="Motivo del canje (opcional)" style="border: 1px solid #4A9DD9; border-radius: 8px;"></textarea>
        </div>

        <input type="hidden" id="canjeCampaniaId" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-cancelar-modal" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-confirmar-canje" id="btnConfirmarCanje">
          <i class="fas fa-check mr-1"></i> Confirmar Canje
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para ajustar puntos -->
<div class="modal fade" id="modalAjuste" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header modal-header-warning">
        <h5 class="modal-title"><i class="fas fa-edit mr-2"></i>Ajustar Puntos</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong style="color: #1A6BA8;">Campaña:</strong> <span id="ajusteNombreCampania"></span></p>
        <p><strong style="color: #1A6BA8;">Puntos actuales:</strong> <span id="ajustePuntosActuales" class="badge badge-info" style="background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);"></span></p>

        <div class="form-group">
          <label for="nuevosPuntos" style="color: #1A6BA8; font-weight: 600;">Nuevos puntos <span class="text-danger">*</span></label>
          <input type="number" class="form-control" id="nuevosPuntos" min="0" required style="border: 1px solid #4A9DD9; border-radius: 8px;">
          <small class="form-text text-muted">Ingrese la cantidad correcta de puntos</small>
        </div>

        <div class="form-group">
          <label for="observacionAjuste" style="color: #1A6BA8; font-weight: 600;">Observación <span class="text-danger">*</span></label>
          <textarea class="form-control" id="observacionAjuste" rows="2"
                    placeholder="Motivo del ajuste (requerido)" required style="border: 1px solid #4A9DD9; border-radius: 8px;"></textarea>
        </div>

        <input type="hidden" id="ajusteCampaniaId" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-cancelar-modal" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-confirmar-ajuste" id="btnConfirmarAjuste">
          <i class="fas fa-save mr-1"></i> Guardar Ajuste
        </button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
let csrfToken = '<?= csrf_hash() ?>';
const csrfName = '<?= csrf_token() ?>';
let clienteActual = null;
let puntosPorCampania = [];

// Función para obtener un token CSRF fresco
function getNewCsrfToken() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '<?= base_url('csrf/token') ?>',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                csrfToken = response.csrf_hash;
                resolve(csrfToken);
            },
            error: function() {
                reject('Error al obtener token');
            }
        });
    });
}

$(document).ready(function() {
    // Buscar con Enter
    $('#documento').on('keypress', function(e) {
        if (e.which === 13) {
            buscarCliente();
        }
    });

    $('#btnBuscar').on('click', buscarCliente);
    $('#btnConfirmarCanje').on('click', confirmarCanje);
    $('#btnConfirmarAjuste').on('click', confirmarAjuste);
});

async function buscarCliente() {
    const documento = $('#documento').val().trim();

    if (!documento || documento.length < 8) {
        Swal.fire('Atención', 'Ingrese un DNI válido (8 dígitos)', 'warning');
        return;
    }

    // Obtener token fresco
    try {
        await getNewCsrfToken();
    } catch (e) {
        console.error(e);
    }

    $.ajax({
        url: '<?= base_url('canjes/buscar-cliente') ?>',
        method: 'POST',
        data: {
            [csrfName]: csrfToken,
            documento: documento
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                clienteActual = response.cliente;
                puntosPorCampania = response.puntos_por_campania;

                // Mostrar info del cliente
                $('#clienteNombre').text(response.cliente.nombres + ' ' + response.cliente.apellidos);
                $('#clienteDni').text(response.cliente.numero_documento);
                $('#clienteTotalPuntos').text(response.total_puntos + ' pts');
                $('#clienteId').val(response.cliente.id);
                $('#clienteInfo').show();

                // Mostrar puntos por campaña
                if (puntosPorCampania.length > 0) {
                    mostrarPuntosPorCampania();
                    $('#panelPuntos').show();
                    $('#sinPuntos').hide();
                } else {
                    $('#panelPuntos').hide();
                    $('#sinPuntos').show();
                }
            } else {
                Swal.fire('No encontrado', response.message, 'warning');
                limpiarCliente();
            }
        },
        error: function() {
            Swal.fire('Error', 'Error al buscar cliente', 'error');
        }
    });
}

function mostrarPuntosPorCampania() {
    let html = '';

    puntosPorCampania.forEach(function(pc) {
        const estadoBadge = pc.campania_estado === 'activa'
            ? '<span class="badge badge-success">Activa</span>'
            : '<span class="badge badge-secondary">Cerrada</span>';

        html += `
            <div class="card campania-item-card mb-3 ${pc.campania_estado === 'activa' ? 'border-success' : 'border-secondary'}" style="background: #ffffff;">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <h5 class="mb-1" style="color: #1A6BA8; font-weight: 600;">${pc.campania_nombre} ${estadoBadge}</h5>
                            <small class="text-muted">ID: ${pc.campania_id}</small>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="h3 mb-0" style="color: #28a745; font-weight: 700;">${pc.puntos_disponibles}</div>
                            <small class="text-muted">Disponibles</small>
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="h5 mb-0" style="color: #6c757d; font-weight: 600;">${pc.puntos_canjeados}</div>
                            <small class="text-muted">Canjeados</small>
                        </div>
                        <div class="col-md-2 text-right">
                            ${pc.puntos_disponibles > 0 ? `
                                <button class="btn btn-canjear-item mb-1" onclick="abrirModalCanje(${pc.campania_id}, '${pc.campania_nombre}', ${pc.puntos_disponibles})">
                                    <i class="fas fa-exchange-alt"></i> Canjear
                                </button>
                            ` : ''}
                            <button class="btn btn-ajustar-item" onclick="abrirModalAjuste(${pc.campania_id}, '${pc.campania_nombre}', ${pc.puntos_disponibles})">
                                <i class="fas fa-edit"></i> Ajustar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    $('#listaPuntosCampania').html(html);
}

function abrirModalCanje(campaniaId, campaniaNombre, puntosDisponibles) {
    $('#canjeCampaniaId').val(campaniaId);
    $('#canjeNombreCampania').text(campaniaNombre);
    $('#canjePuntosDisponibles').text(puntosDisponibles);
    $('#puntosACanjear').val('').attr('max', puntosDisponibles);
    $('#observacionCanje').val('');
    $('#modalCanje').modal('show');
}

function abrirModalAjuste(campaniaId, campaniaNombre, puntosActuales) {
    $('#ajusteCampaniaId').val(campaniaId);
    $('#ajusteNombreCampania').text(campaniaNombre);
    $('#ajustePuntosActuales').text(puntosActuales);
    $('#nuevosPuntos').val(puntosActuales);
    $('#observacionAjuste').val('');
    $('#modalAjuste').modal('show');
}

async function confirmarCanje() {
    const clienteId = $('#clienteId').val();
    const campaniaId = $('#canjeCampaniaId').val();
    const puntos = parseInt($('#puntosACanjear').val());
    const observacion = $('#observacionCanje').val();
    const puntosDisponibles = parseInt($('#canjePuntosDisponibles').text());

    if (!puntos || puntos <= 0) {
        Swal.fire('Atención', 'Ingrese una cantidad válida de puntos', 'warning');
        return;
    }

    if (puntos > puntosDisponibles) {
        Swal.fire('Error', `No puede canjear más de ${puntosDisponibles} puntos`, 'error');
        return;
    }

    const result = await Swal.fire({
        title: '¿Confirmar canje?',
        html: `Se descontarán <strong>${puntos} puntos</strong> del cliente.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, canjear',
        cancelButtonText: 'Cancelar'
    });

    if (result.isConfirmed) {
        // Obtener token fresco antes de enviar
        try {
            await getNewCsrfToken();
        } catch (e) {
            console.error(e);
        }

        $.ajax({
            url: '<?= base_url('canjes/registrar') ?>',
            method: 'POST',
            data: {
                [csrfName]: csrfToken,
                cliente_id: clienteId,
                campania_id: campaniaId,
                puntos: puntos,
                observacion: observacion
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#modalCanje').modal('hide');

                    Swal.fire({
                        title: 'Canje Exitoso',
                        html: `${response.message}<br><br>
                               <a href="<?= base_url('canjes/ticket/') ?>${response.canje_id}" target="_blank" class="btn btn-primary">
                                   <i class="fas fa-print"></i> Imprimir Comprobante
                               </a>`,
                        icon: 'success'
                    });

                    // Recargar datos del cliente
                    buscarCliente();
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Error al procesar el canje', 'error');
            }
        });
    }
}

async function confirmarAjuste() {
    const clienteId = $('#clienteId').val();
    const campaniaId = $('#ajusteCampaniaId').val();
    const nuevosPuntos = parseInt($('#nuevosPuntos').val());
    const observacion = $('#observacionAjuste').val().trim();

    if (nuevosPuntos < 0) {
        Swal.fire('Atención', 'Los puntos no pueden ser negativos', 'warning');
        return;
    }

    if (!observacion) {
        Swal.fire('Atención', 'Debe ingresar una observación para el ajuste', 'warning');
        return;
    }

    const result = await Swal.fire({
        title: '¿Confirmar ajuste?',
        html: `Los puntos se ajustarán a <strong>${nuevosPuntos}</strong>.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ffc107',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, ajustar',
        cancelButtonText: 'Cancelar'
    });

    if (result.isConfirmed) {
        // Obtener token fresco antes de enviar
        try {
            await getNewCsrfToken();
        } catch (e) {
            console.error(e);
        }

        $.ajax({
            url: '<?= base_url('canjes/ajustar') ?>',
            method: 'POST',
            data: {
                [csrfName]: csrfToken,
                cliente_id: clienteId,
                campania_id: campaniaId,
                nuevos_puntos: nuevosPuntos,
                observacion: observacion
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#modalAjuste').modal('hide');
                    Swal.fire('Ajuste Realizado', response.message, 'success');
                    buscarCliente();
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Error al procesar el ajuste', 'error');
            }
        });
    }
}

function limpiarCliente() {
    clienteActual = null;
    puntosPorCampania = [];
    $('#clienteInfo').hide();
    $('#panelPuntos').hide();
    $('#sinPuntos').hide();
}
</script>
<?= $this->endSection() ?>
