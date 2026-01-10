<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2><i class="fas fa-coins"></i> Gestionar Puntos - <?= esc($campania['nombre']) ?></h2>
                <a href="<?= base_url('campanias') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <strong>Campaña cerrada:</strong> <?= esc($campania['nombre']) ?>
                (Cerrada el <?= date('d/m/Y H:i', strtotime($campania['closed_at'])) ?>)
                <br>
                <small>Desde aquí puedes migrar los puntos de los clientes a la campaña activa o eliminarlos.</small>
            </div>
        </div>
    </div>

    <?php if (!$campaniaActiva): ?>
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>No hay campaña activa.</strong>
                Crea una nueva campaña antes de migrar puntos.
                <a href="<?= base_url('campanias/crear') ?>" class="btn btn-primary btn-sm ml-2">
                    <i class="fas fa-plus"></i> Crear Campaña
                </a>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <strong>Campaña activa disponible:</strong> <?= esc($campaniaActiva['nombre']) ?>
                <br>
                <small>Los puntos migrados se agregarán a esta campaña.</small>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users"></i> Clientes con puntos en esta campaña
                        <span class="badge badge-primary"><?= count($clientesConPuntos) ?></span>
                    </h3>
                </div>
                <div class="card-body">
                    <?php if (empty($clientesConPuntos)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <p class="lead">No hay clientes con puntos pendientes en esta campaña.</p>
                        </div>
                    <?php else: ?>
                        <table id="puntosTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Documento</th>
                                    <th>Puntos Disponibles</th>
                                    <th>Puntos Canjeados</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clientesConPuntos as $cliente): ?>
                                <tr id="fila-<?= $cliente['cliente_id'] ?>">
                                    <td><?= esc($cliente['nombres'] . ' ' . $cliente['apellidos']) ?></td>
                                    <td><?= esc($cliente['numero_documento']) ?></td>
                                    <td>
                                        <span class="badge badge-success" style="font-size: 1.1em;">
                                            <?= number_format($cliente['puntos_disponibles']) ?> pts
                                        </span>
                                    </td>
                                    <td><?= number_format($cliente['puntos_canjeados']) ?> pts</td>
                                    <td>
                                        <?php if ($campaniaActiva): ?>
                                        <button type="button" class="btn btn-primary btn-sm"
                                                onclick="migrarPuntos(<?= $cliente['cliente_id'] ?>, <?= $campania['id'] ?>, 'migrar', <?= $cliente['puntos_disponibles'] ?>)">
                                            <i class="fas fa-exchange-alt"></i> Migrar
                                        </button>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="migrarPuntos(<?= $cliente['cliente_id'] ?>, <?= $campania['id'] ?>, 'eliminar', <?= $cliente['puntos_disponibles'] ?>)">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <?php if ($campaniaActiva): ?>
                        <div class="mt-3">
                            <button type="button" class="btn btn-success" onclick="migrarTodos()">
                                <i class="fas fa-exchange-alt"></i> Migrar Todos los Puntos
                            </button>
                            <button type="button" class="btn btn-danger" onclick="eliminarTodos()">
                                <i class="fas fa-trash"></i> Eliminar Todos los Puntos
                            </button>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const CSRF_TOKEN = '<?= csrf_hash() ?>';
const campaniaOrigenId = <?= $campania['id'] ?>;

function migrarPuntos(clienteId, campaniaId, accion, puntos) {
    const accionTexto = accion === 'migrar' ? 'migrar' : 'eliminar';
    const confirmTexto = accion === 'migrar'
        ? `¿Migrar ${puntos} puntos a la campaña activa?`
        : `¿Eliminar ${puntos} puntos permanentemente?`;

    Swal.fire({
        title: confirmTexto,
        icon: accion === 'migrar' ? 'question' : 'warning',
        showCancelButton: true,
        confirmButtonColor: accion === 'migrar' ? '#3085d6' : '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: accion === 'migrar' ? 'Sí, migrar' : 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('<?= base_url('campanias/migrar-puntos') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `<?= csrf_token() ?>=${CSRF_TOKEN}&cliente_id=${clienteId}&campania_origen_id=${campaniaId}&accion=${accion}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Completado', data.message, 'success');
                    document.getElementById('fila-' + clienteId).remove();

                    // Si no quedan filas, recargar
                    if (document.querySelectorAll('#puntosTable tbody tr').length === 0) {
                        location.reload();
                    }
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Ocurrió un error al procesar la solicitud', 'error');
            });
        }
    });
}

function migrarTodos() {
    Swal.fire({
        title: '¿Migrar TODOS los puntos?',
        text: 'Se migrarán todos los puntos de todos los clientes a la campaña activa.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, migrar todos',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const filas = document.querySelectorAll('#puntosTable tbody tr');
            filas.forEach(fila => {
                const clienteId = fila.id.replace('fila-', '');
                migrarPuntosAuto(clienteId, campaniaOrigenId, 'migrar');
            });
        }
    });
}

function eliminarTodos() {
    Swal.fire({
        title: '¿Eliminar TODOS los puntos?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar todos',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const filas = document.querySelectorAll('#puntosTable tbody tr');
            filas.forEach(fila => {
                const clienteId = fila.id.replace('fila-', '');
                migrarPuntosAuto(clienteId, campaniaOrigenId, 'eliminar');
            });
        }
    });
}

function migrarPuntosAuto(clienteId, campaniaId, accion) {
    fetch('<?= base_url('campanias/migrar-puntos') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `<?= csrf_token() ?>=${CSRF_TOKEN}&cliente_id=${clienteId}&campania_origen_id=${campaniaId}&accion=${accion}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const fila = document.getElementById('fila-' + clienteId);
            if (fila) fila.remove();

            if (document.querySelectorAll('#puntosTable tbody tr').length === 0) {
                location.reload();
            }
        }
    });
}

$(document).ready(function() {
    $('#puntosTable').DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        pageLength: 25
    });
});
</script>
<?= $this->endSection() ?>
