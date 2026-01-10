<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2><i class="fas fa-bullhorn"></i> Gestión de Campañas</h2>
                <a href="<?= base_url('campanias/crear') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nueva Campaña
                </a>
            </div>
        </div>
    </div>

    <?php if ($campaniaActiva): ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-star"></i> Campaña Activa</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4><?= esc($campaniaActiva['nombre']) ?></h4>
                            <p class="text-muted"><?= esc($campaniaActiva['descripcion'] ?? 'Sin descripción') ?></p>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <strong>Regla base:</strong><br>
                                    <?= $campaniaActiva['puntos_por_monto'] ?> punto(s) por cada S/ <?= number_format($campaniaActiva['monto_base'], 2) ?>
                                </div>
                                <div class="col-6">
                                    <strong>Reglas especiales:</strong><br>
                                    <?php if ($campaniaActiva['puntos_dobles_finsemana']): ?>
                                        <span class="badge badge-info"><i class="fas fa-calendar-week"></i> Puntos dobles fin de semana</span><br>
                                    <?php endif; ?>
                                    <?php if ($campaniaActiva['multiplicador_monto_minimo']): ?>
                                        <span class="badge badge-warning"><i class="fas fa-times"></i> x<?= $campaniaActiva['multiplicador_valor'] ?> en compras >= S/ <?= number_format($campaniaActiva['multiplicador_monto_minimo'], 2) ?></span>
                                    <?php endif; ?>
                                    <?php if (!$campaniaActiva['puntos_dobles_finsemana'] && !$campaniaActiva['multiplicador_monto_minimo']): ?>
                                        <span class="text-muted">Ninguna</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex gap-2">
                        <a href="<?= base_url('campanias/editar/' . $campaniaActiva['id']) ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button type="button" class="btn btn-danger btn-sm ml-2" onclick="confirmarCerrar(<?= $campaniaActiva['id'] ?>)">
                            <i class="fas fa-stop-circle"></i> Cerrar Campaña
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> <strong>No hay campaña activa.</strong>
                Crea una nueva campaña para comenzar a acumular puntos.
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-history"></i> Historial de Campañas</h3>
                </div>
                <div class="card-body">
                    <table id="campaniasTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Regla Base</th>
                                <th>Reglas Especiales</th>
                                <th>Estado</th>
                                <th>Creado por</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($campanias as $campania): ?>
                            <tr>
                                <td><?= $campania['id'] ?></td>
                                <td><?= esc($campania['nombre']) ?></td>
                                <td><?= $campania['puntos_por_monto'] ?> pts / S/ <?= number_format($campania['monto_base'], 2) ?></td>
                                <td>
                                    <?php if ($campania['puntos_dobles_finsemana']): ?>
                                        <span class="badge badge-info" title="Puntos dobles fin de semana"><i class="fas fa-calendar-week"></i></span>
                                    <?php endif; ?>
                                    <?php if ($campania['multiplicador_monto_minimo']): ?>
                                        <span class="badge badge-warning" title="Multiplicador x<?= $campania['multiplicador_valor'] ?> en compras >= S/ <?= number_format($campania['multiplicador_monto_minimo'], 2) ?>"><i class="fas fa-times"></i> x<?= $campania['multiplicador_valor'] ?></span>
                                    <?php endif; ?>
                                    <?php if (!$campania['puntos_dobles_finsemana'] && !$campania['multiplicador_monto_minimo']): ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($campania['estado'] === 'activa'): ?>
                                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Activa</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary"><i class="fas fa-times-circle"></i> Cerrada</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($campania['creador_nombre']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($campania['created_at'])) ?></td>
                                <td>
                                    <?php if ($campania['estado'] === 'activa'): ?>
                                        <a href="<?= base_url('campanias/editar/' . $campania['id']) ?>" class="btn btn-warning btn-xs" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('campanias/gestionar-puntos/' . $campania['id']) ?>" class="btn btn-info btn-xs" title="Gestionar puntos">
                                            <i class="fas fa-coins"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form oculto para cerrar campaña -->
<form id="formCerrar" action="" method="post" style="display: none;">
    <?= csrf_field() ?>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#campaniasTable').DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        order: [[0, 'desc']],
        pageLength: 10
    });
});

function confirmarCerrar(id) {
    Swal.fire({
        title: '¿Cerrar esta campaña?',
        html: `<p>Al cerrar la campaña:</p>
               <ul class="text-left">
                 <li>No se podrán acumular más puntos con esta campaña</li>
                 <li>Los clientes conservarán sus puntos existentes</li>
                 <li>Deberás crear una nueva campaña para continuar</li>
               </ul>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, cerrar campaña',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('formCerrar');
            form.action = '<?= base_url('campanias/cerrar/') ?>' + id;
            form.submit();
        }
    });
}
</script>
<?= $this->endSection() ?>
