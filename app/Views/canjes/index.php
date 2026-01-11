<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4"><i class="fas fa-exchange-alt"></i> Canje de Puntos</h2>
        </div>
    </div>

    <?php if (!$campaniaActiva): ?>
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Atención:</strong> No hay campaña activa. Los canjes solo pueden realizarse sobre puntos existentes.
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- Panel de búsqueda -->
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-search"></i> Buscar Cliente</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="documento">DNI del Cliente</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="documento"
                                   placeholder="Ingrese DNI" maxlength="8" autofocus>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="btnBuscar">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info del cliente -->
            <div id="clienteInfo" class="card card-success" style="display: none;">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user"></i> Cliente Encontrado</h3>
                </div>
                <div class="card-body">
                    <h4 id="clienteNombre" class="mb-2"></h4>
                    <p class="mb-1"><strong>DNI:</strong> <span id="clienteDni"></span></p>
                    <p class="mb-0">
                        <strong>Total Puntos:</strong>
                        <span id="clienteTotalPuntos" class="badge badge-success" style="font-size: 1.2em;"></span>
                    </p>
                    <input type="hidden" id="clienteId" value="">
                </div>
            </div>
        </div>

        <!-- Panel de puntos por campaña -->
        <div class="col-md-8">
            <div id="panelPuntos" class="card" style="display: none;">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title"><i class="fas fa-coins"></i> Puntos por Campaña</h3>
                </div>
                <div class="card-body">
                    <div id="listaPuntosCampania">
                        <!-- Se llena dinámicamente -->
                    </div>
                </div>
            </div>

            <!-- Sin puntos -->
            <div id="sinPuntos" class="alert alert-info" style="display: none;">
                <i class="fas fa-info-circle"></i> Este cliente no tiene puntos disponibles para canjear.
            </div>
        </div>
    </div>
</div>

<!-- Modal para canjear puntos -->
<div class="modal fade" id="modalCanje" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-exchange-alt"></i> Canjear Puntos</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Campaña:</strong> <span id="canjeNombreCampania"></span></p>
                <p><strong>Puntos disponibles:</strong> <span id="canjePuntosDisponibles" class="badge badge-success"></span></p>

                <div class="form-group">
                    <label for="puntosACanjear">Puntos a canjear <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="puntosACanjear" min="1" required>
                    <small class="form-text text-muted">Ingrese la cantidad de puntos a descontar</small>
                </div>

                <div class="form-group">
                    <label for="observacionCanje">Observación</label>
                    <textarea class="form-control" id="observacionCanje" rows="2"
                              placeholder="Motivo del canje (opcional)"></textarea>
                </div>

                <input type="hidden" id="canjeCampaniaId" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnConfirmarCanje">
                    <i class="fas fa-check"></i> Confirmar Canje
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ajustar puntos -->
<div class="modal fade" id="modalAjuste" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Ajustar Puntos</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Campaña:</strong> <span id="ajusteNombreCampania"></span></p>
                <p><strong>Puntos actuales:</strong> <span id="ajustePuntosActuales" class="badge badge-info"></span></p>

                <div class="form-group">
                    <label for="nuevosPuntos">Nuevos puntos <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="nuevosPuntos" min="0" required>
                    <small class="form-text text-muted">Ingrese la cantidad correcta de puntos</small>
                </div>

                <div class="form-group">
                    <label for="observacionAjuste">Observación <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="observacionAjuste" rows="2"
                              placeholder="Motivo del ajuste (requerido)" required></textarea>
                </div>

                <input type="hidden" id="ajusteCampaniaId" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="btnConfirmarAjuste">
                    <i class="fas fa-save"></i> Guardar Ajuste
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
            <div class="card mb-3 ${pc.campania_estado === 'activa' ? 'border-success' : 'border-secondary'}">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <h5 class="mb-1">${pc.campania_nombre} ${estadoBadge}</h5>
                            <small class="text-muted">ID: ${pc.campania_id}</small>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="h3 text-success mb-0">${pc.puntos_disponibles}</div>
                            <small class="text-muted">Disponibles</small>
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="h5 text-secondary mb-0">${pc.puntos_canjeados}</div>
                            <small class="text-muted">Canjeados</small>
                        </div>
                        <div class="col-md-2 text-right">
                            ${pc.puntos_disponibles > 0 ? `
                                <button class="btn btn-success btn-sm mb-1" onclick="abrirModalCanje(${pc.campania_id}, '${pc.campania_nombre}', ${pc.puntos_disponibles})">
                                    <i class="fas fa-exchange-alt"></i> Canjear
                                </button>
                            ` : ''}
                            <button class="btn btn-warning btn-sm" onclick="abrirModalAjuste(${pc.campania_id}, '${pc.campania_nombre}', ${pc.puntos_disponibles})">
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
