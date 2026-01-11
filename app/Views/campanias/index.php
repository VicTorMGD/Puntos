<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
  .campanias-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    margin-bottom: 20px;
  }

  .campanias-card-header {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    padding: 18px 24px;
  }

  .campanias-card-header .card-title {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
  }

  .campanias-card-body {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
    padding: 20px;
  }

  .campania-activa-card {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
  }

  .campania-activa-card .card-header {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: #fff;
  }

  .btn-nueva-campania {
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

  .btn-nueva-campania:hover {
    background: linear-gradient(90deg, #ff7a45 0%, #ffb319 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 107, 53, 0.3);
    color: #ffffff;
  }

  .btn-editar-campania {
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

  .btn-editar-campania:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 193, 7, 0.3);
    color: #fff;
  }

  .btn-cerrar-campania {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 50px;
    padding: 6px 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    font-size: 0.85rem;
  }

  .btn-cerrar-campania:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(220, 53, 69, 0.3);
    color: #fff;
  }

  .btn-gestionar-puntos {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 50px;
    padding: 6px 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    font-size: 0.85rem;
  }

  .btn-gestionar-puntos:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(26, 107, 168, 0.3);
    color: #fff;
  }

  #campaniasTable {
    background-color: #ffffff;
    border-radius: 12px;
    overflow: hidden;
  }

  #campaniasTable thead {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
  }

  #campaniasTable thead th {
    border-color: rgba(255, 255, 255, 0.2);
    font-weight: 600;
  }

  #campaniasTable tbody tr:nth-child(even) {
    background-color: #F0F7FB;
  }

  #campaniasTable tbody tr:hover {
    background-color: #C8E0F0;
  }

  #campaniasTable td,
  #campaniasTable th {
    vertical-align: middle;
  }

  .alert-warning-custom {
    background: linear-gradient(135deg, #fff3cd 0%, #ffffff 100%);
    border-left: 4px solid #ffc107;
    border-radius: 10px;
    color: #856404;
  }
</style>

<div class="container-fluid">
  <div class="row mb-3">
    <div class="col-12">
      <div class="campanias-card">
        <div class="campanias-card-header">
          <div class="d-flex justify-content-between align-items-center">
            <h2 class="card-title"><i class="fas fa-bullhorn mr-2"></i>Gestión de Campañas</h2>
            <a href="<?= base_url('campanias/crear') ?>" class="btn btn-nueva-campania">
              <i class="fas fa-plus mr-1"></i> Nueva Campaña
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php if ($campaniaActiva): ?>
  <div class="row mb-4">
    <div class="col-12">
      <div class="card campania-activa-card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-star mr-2"></i>Campaña Activa</h3>
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
            <a href="<?= base_url('campanias/editar/' . $campaniaActiva['id']) ?>" class="btn btn-editar-campania">
              <i class="fas fa-edit mr-1"></i> Editar
            </a>
            <button type="button" class="btn btn-cerrar-campania" onclick="confirmarCerrar(<?= $campaniaActiva['id'] ?>)">
              <i class="fas fa-stop-circle mr-1"></i> Cerrar Campaña
            </button>
          </div>
                </div>
            </div>
        </div>
    </div>
  <?php else: ?>
  <div class="row mb-4">
    <div class="col-12">
      <div class="alert alert-warning-custom">
        <i class="fas fa-exclamation-triangle"></i> <strong>No hay campaña activa.</strong>
        Crea una nueva campaña para comenzar a acumular puntos.
      </div>
    </div>
  </div>
  <?php endif; ?>

  <div class="row">
    <div class="col-12">
      <div class="campanias-card">
        <div class="campanias-card-header">
          <h3 class="card-title"><i class="fas fa-history mr-2"></i>Historial de Campañas</h3>
        </div>
        <div class="campanias-card-body">
          <table id="campaniasTable" class="table table-bordered table-hover mb-0">
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
                                    <a href="<?= base_url('campanias/editar/' . $campania['id']) ?>" class="btn btn-editar-campania btn-sm" title="Editar">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                  <?php else: ?>
                                    <a href="<?= base_url('campanias/gestionar-puntos/' . $campania['id']) ?>" class="btn btn-gestionar-puntos btn-sm" title="Gestionar puntos">
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
