<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
  .gestionar-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
  }

  .gestionar-card-header {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .gestionar-card-header h3 {
    margin: 0;
    font-size: 1.35rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
  }

  .gestionar-card-body {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
    padding: 20px 22px 24px;
  }

  .btn-volver-gestionar {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 50px;
    padding: 10px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
  }

  .btn-volver-gestionar:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(108, 117, 125, 0.3);
    color: #fff;
  }

  .btn-nueva-campania {
    background: linear-gradient(90deg, #ff6b35 0%, #ffa500 100%);
    border: none;
    color: #ffffff;
    font-weight: 600;
    border-radius: 50px;
    padding: 8px 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    letter-spacing: 0.5px;
    font-size: 0.85rem;
  }

  .btn-nueva-campania:hover {
    background: linear-gradient(90deg, #ff7a45 0%, #ffb319 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 107, 53, 0.3);
    color: #ffffff;
  }

  .btn-migrar-puntos {
    background: linear-gradient(90deg, #ff6b35 0%, #ffa500 100%);
    border: none;
    color: #ffffff;
    font-weight: 600;
    border-radius: 50px;
    padding: 6px 14px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    font-size: 0.85rem;
  }

  .btn-migrar-puntos:hover {
    background: linear-gradient(90deg, #ff7a45 0%, #ffb319 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 107, 53, 0.3);
    color: #ffffff;
  }

  .btn-eliminar-puntos {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 50px;
    padding: 6px 14px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    font-size: 0.85rem;
  }

  .btn-eliminar-puntos:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(220, 53, 69, 0.3);
    color: #fff;
  }

  .btn-migrar-todos {
    background: linear-gradient(90deg, #ff6b35 0%, #ffa500 100%);
    border: none;
    color: #ffffff;
    font-weight: 600;
    border-radius: 50px;
    padding: 12px 24px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    letter-spacing: 0.5px;
  }

  .btn-migrar-todos:hover {
    background: linear-gradient(90deg, #ff7a45 0%, #ffb319 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 107, 53, 0.3);
    color: #ffffff;
  }

  .btn-eliminar-todos {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 50px;
    padding: 12px 24px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
  }

  .btn-eliminar-todos:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(220, 53, 69, 0.3);
    color: #fff;
  }

  .section-title {
    color: #1A6BA8;
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #C8E0F0;
  }

  #puntosTable {
    background-color: #ffffff;
    border-radius: 12px;
    overflow: hidden;
  }

  #puntosTable thead {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
  }

  #puntosTable thead th {
    border-color: rgba(255, 255, 255, 0.2);
    font-weight: 600;
    padding: 12px 10px;
  }

  #puntosTable tbody tr:nth-child(even) {
    background-color: #F0F7FB;
  }

  #puntosTable tbody tr:hover {
    background-color: #C8E0F0;
  }

  #puntosTable td,
  #puntosTable th {
    vertical-align: middle;
  }

  .alert-info-custom {
    background: linear-gradient(135deg, #D4E8F5 0%, #ffffff 100%);
    border-left: 4px solid #1A6BA8;
    border-radius: 10px;
    color: #1A6BA8;
    padding: 15px 20px;
  }

  .alert-warning-custom {
    background: linear-gradient(135deg, #fff3cd 0%, #ffffff 100%);
    border-left: 4px solid #ffc107;
    border-radius: 10px;
    color: #856404;
    padding: 15px 20px;
  }

  .alert-success-custom {
    background: linear-gradient(135deg, #d4edda 0%, #ffffff 100%);
    border-left: 4px solid #28a745;
    border-radius: 10px;
    color: #155724;
    padding: 15px 20px;
  }

  .info-campania-box {
    background-color: #ffffff;
    border-radius: 14px;
    padding: 15px 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    border-left: 4px solid #6c757d;
    margin-bottom: 20px;
  }

  .empty-state {
    text-align: center;
    padding: 40px 20px;
  }

  .empty-state i {
    font-size: 4rem;
    color: #28a745;
    margin-bottom: 15px;
  }

  .footer-actions {
    background: #ffffff;
    border-top: 1px solid #D4E8F5;
    padding: 20px 22px;
    border-radius: 0 0 18px 18px;
  }
</style>

<div class="card gestionar-card">
  <div class="gestionar-card-header">
    <h3><i class="fas fa-coins mr-2"></i>Gestionar Puntos - <?= esc($campania['nombre']) ?></h3>
    <a href="<?= base_url('campanias') ?>" class="btn btn-volver-gestionar">
      <i class="fas fa-arrow-left mr-1"></i> Volver
    </a>
  </div>

  <div class="gestionar-card-body">
    <!-- Info de la campaña cerrada -->
    <div class="info-campania-box">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h5 class="mb-1" style="color: #6c757d; font-weight: 600;">
            <i class="fas fa-archive mr-2"></i>Campaña Cerrada
          </h5>
          <p class="mb-0 text-muted">
            <?= esc($campania['nombre']) ?> - Cerrada el <?= date('d/m/Y H:i', strtotime($campania['closed_at'])) ?>
          </p>
        </div>
        <div class="col-md-4 text-right">
          <span class="badge badge-secondary" style="font-size: 1rem; padding: 8px 15px;">
            <i class="fas fa-users mr-1"></i> <?= count($clientesConPuntos) ?> clientes con puntos
          </span>
        </div>
      </div>
    </div>

    <!-- Estado de campaña activa -->
    <?php if (!$campaniaActiva): ?>
    <div class="alert alert-warning-custom mb-4">
      <i class="fas fa-exclamation-triangle mr-2"></i>
      <strong>No hay campaña activa.</strong>
      Crea una nueva campaña antes de migrar puntos.
      <a href="<?= base_url('campanias/crear') ?>" class="btn btn-nueva-campania ml-3">
        <i class="fas fa-plus mr-1"></i> Crear Campaña
      </a>
    </div>
    <?php else: ?>
    <div class="alert alert-success-custom mb-4">
      <i class="fas fa-check-circle mr-2"></i>
      <strong>Campaña activa disponible:</strong> <?= esc($campaniaActiva['nombre']) ?>
      <small class="d-block mt-1">Los puntos migrados se agregarán a esta campaña.</small>
    </div>
    <?php endif; ?>

    <!-- Tabla de clientes -->
    <h5 class="section-title"><i class="fas fa-list mr-2"></i>Clientes con Puntos Pendientes</h5>

    <?php if (empty($clientesConPuntos)): ?>
    <div class="empty-state">
      <i class="fas fa-check-circle"></i>
      <h4 style="color: #28a745;">Todo en orden</h4>
      <p class="text-muted">No hay clientes con puntos pendientes en esta campaña.</p>
    </div>
    <?php else: ?>
    <div class="table-responsive">
      <table id="puntosTable" class="table table-bordered table-hover mb-0">
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
            <td><strong><?= esc($cliente['nombres'] . ' ' . $cliente['apellidos']) ?></strong></td>
            <td><?= esc($cliente['numero_documento']) ?></td>
            <td>
              <span class="badge badge-success" style="font-size: 1.1em; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <?= number_format($cliente['puntos_disponibles']) ?> pts
              </span>
            </td>
            <td><?= number_format($cliente['puntos_canjeados']) ?> pts</td>
            <td>
              <?php if ($campaniaActiva): ?>
              <button type="button" class="btn btn-migrar-puntos mr-1"
                      onclick="migrarPuntos(<?= $cliente['cliente_id'] ?>, <?= $campania['id'] ?>, 'migrar', <?= $cliente['puntos_disponibles'] ?>)">
                <i class="fas fa-exchange-alt"></i> Migrar
              </button>
              <?php endif; ?>
              <button type="button" class="btn btn-eliminar-puntos"
                      onclick="migrarPuntos(<?= $cliente['cliente_id'] ?>, <?= $campania['id'] ?>, 'eliminar', <?= $cliente['puntos_disponibles'] ?>)">
                <i class="fas fa-trash"></i> Eliminar
              </button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>

  <?php if (!empty($clientesConPuntos) && $campaniaActiva): ?>
  <div class="footer-actions">
    <button type="button" class="btn btn-migrar-todos mr-2" onclick="migrarTodos()">
      <i class="fas fa-exchange-alt mr-1"></i> Migrar Todos los Puntos
    </button>
    <button type="button" class="btn btn-eliminar-todos" onclick="eliminarTodos()">
      <i class="fas fa-trash mr-1"></i> Eliminar Todos los Puntos
    </button>
  </div>
  <?php endif; ?>
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
    confirmButtonColor: accion === 'migrar' ? '#28a745' : '#d33',
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
