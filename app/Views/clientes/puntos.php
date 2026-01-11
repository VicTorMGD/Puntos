<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
  .puntos-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    margin-bottom: 20px;
  }


  .puntos-card-header {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    padding: 18px 24px;
  }

  .puntos-card-header h3 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
  }

  .puntos-card-body {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
    padding: 18px 22px 22px;
  }

  .info-puntos {
    background-color: #ffffff;
    padding: 12px 18px;
    border-radius: 10px;
    margin-bottom: 18px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  }

  .info-puntos strong {
    color: #1A6BA8;
    font-size: 1.1rem;
  }

  .campania-card {
    background: #fff;
    border-radius: 12px;
    padding: 15px 20px;
    margin-bottom: 15px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border-left: 4px solid #1A6BA8;
  }

  .campania-card.activa {
    border-left-color: #28a745;
    background: linear-gradient(to right, #f0fff4 0%, #ffffff 100%);
  }

  .campania-card.cerrada {
    border-left-color: #6c757d;
    opacity: 0.85;
  }

  .campania-nombre {
    font-weight: 600;
    font-size: 1.1rem;
    color: #1A6BA8;
  }

  .campania-estado {
    font-size: 0.75rem;
    padding: 3px 8px;
    border-radius: 12px;
    text-transform: uppercase;
    font-weight: 600;
  }

  .campania-estado.activa {
    background: #d4edda;
    color: #155724;
  }

  .campania-estado.cerrada {
    background: #e2e3e5;
    color: #383d41;
  }

  .puntos-display {
    display: flex;
    gap: 20px;
    margin-top: 10px;
  }

  .puntos-item {
    text-align: center;
    padding: 10px 15px;
    background: #f8f9fa;
    border-radius: 8px;
    min-width: 100px;
  }

  .puntos-item .numero {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1A6BA8;
  }

  .puntos-item .label {
    font-size: 0.8rem;
    color: #666;
  }

  .puntos-item.disponibles .numero {
    color: #28a745;
  }

  .puntos-item.canjeados .numero {
    color: #dc3545;
  }

  .table-styled {
    background-color: #ffffff;
    border-radius: 12px;
    overflow: hidden;
  }

  .table-styled thead {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
  }

  .table-styled thead th {
    border-color: rgba(255, 255, 255, 0.2);
    font-weight: 600;
  }

  .table-styled tbody tr:nth-child(even) {
    background-color: #F0F7FB;
  }

  .table-styled tbody tr:hover {
    background-color: #C8E0F0;
  }

  .table-styled td,
  .table-styled th {
    vertical-align: middle;
  }

  .nav-tabs .nav-link {
    color: #1A6BA8;
    border: none;
    border-bottom: 2px solid transparent;
  }

  .nav-tabs .nav-link.active {
    color: #1A6BA8;
    font-weight: 600;
    border-bottom: 2px solid #1A6BA8;
    background: transparent;
  }

  .nav-tabs .nav-link:hover {
    border-bottom: 2px solid #4A9DD9;
  }

  .tab-content {
    padding-top: 20px;
  }

  .total-general {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    padding: 20px;
    border-radius: 12px;
    text-align: center;
  }

  .total-general .numero {
    font-size: 2.5rem;
    font-weight: 700;
  }

  .total-general .label {
    font-size: 0.9rem;
    opacity: 0.9;
  }

  .btn-volver {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 50px;
    padding: 10px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    margin-bottom: 15px;
  }

  .btn-volver:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(108, 117, 125, 0.3);
    color: #fff;
  }
</style>

<a href="<?= site_url('clientes') ?>" class="btn btn-volver">
  <i class="fas fa-arrow-left mr-1"></i> Volver a Clientes
</a>

<div class="card puntos-card">
  <div class="puntos-card-header">
    <h3>
      <i class="fas fa-user"></i>
      <?= esc($cliente['nombres'] . ' ' . $cliente['apellidos']) ?>
      <small class="d-block mt-1" style="font-size: 0.9rem; opacity: 0.9;">
        DNI: <?= esc($cliente['numero_documento']) ?>
      </small>
    </h3>
  </div>

  <div class="puntos-card-body">
    <!-- Resumen Total -->
    <div class="row mb-4">
      <div class="col-md-4">
        <div class="total-general">
          <div class="numero"><?= number_format($cliente['puntos_acumulados']) ?></div>
          <div class="label">Puntos Totales Disponibles</div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="info-puntos h-100 d-flex align-items-center">
          <div>
            <strong><i class="fas fa-info-circle"></i> Información del Cliente</strong>
            <p class="mb-1 mt-2">
              <?php if ($cliente['telefono']): ?>
                <i class="fas fa-phone"></i> <?= esc($cliente['telefono']) ?> &nbsp;|&nbsp;
              <?php endif; ?>
              <?php if ($cliente['email']): ?>
                <i class="fas fa-envelope"></i> <?= esc($cliente['email']) ?>
              <?php endif; ?>
              <?php if (!$cliente['telefono'] && !$cliente['email']): ?>
                <span class="text-muted">Sin información de contacto registrada</span>
              <?php endif; ?>
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Tabs de contenido -->
    <ul class="nav nav-tabs" id="puntosTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="campanias-tab" data-toggle="tab" href="#campanias" role="tab">
          <i class="fas fa-bullhorn"></i> Puntos por Campaña
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="canjes-tab" data-toggle="tab" href="#canjes" role="tab">
          <i class="fas fa-gift"></i> Canjes (<?= count($canjes) ?>)
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="ajustes-tab" data-toggle="tab" href="#ajustes" role="tab">
          <i class="fas fa-sliders-h"></i> Ajustes (<?= count($ajustes) ?>)
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="historial-tab" data-toggle="tab" href="#historial" role="tab">
          <i class="fas fa-history"></i> Historial General
        </a>
      </li>
    </ul>

    <div class="tab-content" id="puntosTabContent">
      <!-- Tab: Puntos por Campaña -->
      <div class="tab-pane fade show active" id="campanias" role="tabpanel">
        <?php if (empty($puntosPorCampania)): ?>
          <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Este cliente aún no tiene puntos registrados en ninguna campaña.
          </div>
        <?php else: ?>
          <?php foreach ($puntosPorCampania as $pc): ?>
            <div class="campania-card <?= $pc['campania_estado'] ?>">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <span class="campania-nombre"><?= esc($pc['campania_nombre']) ?></span>
                  <span class="campania-estado <?= $pc['campania_estado'] ?> ml-2">
                    <?= $pc['campania_estado'] ?>
                  </span>
                </div>
              </div>
              <div class="puntos-display">
                <div class="puntos-item disponibles">
                  <div class="numero"><?= number_format($pc['puntos_disponibles']) ?></div>
                  <div class="label">Disponibles</div>
                </div>
                <div class="puntos-item canjeados">
                  <div class="numero"><?= number_format($pc['puntos_canjeados']) ?></div>
                  <div class="label">Canjeados</div>
                </div>
                <div class="puntos-item">
                  <div class="numero"><?= number_format($pc['puntos_disponibles'] + $pc['puntos_canjeados']) ?></div>
                  <div class="label">Total Acumulado</div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- Tab: Canjes -->
      <div class="tab-pane fade" id="canjes" role="tabpanel">
        <?php if (empty($canjes)): ?>
          <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Este cliente aún no ha realizado canjes.
          </div>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0 table-styled">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Campaña</th>
                  <th>Puntos</th>
                  <th>Observación</th>
                  <th>Atendido por</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($canjes as $c): ?>
                  <tr>
                    <td><?= date('d/m/Y H:i', strtotime($c['created_at'])) ?></td>
                    <td><?= esc($c['campania_nombre']) ?></td>
                    <td class="text-danger font-weight-bold">-<?= number_format($c['puntos_canjeados']) ?></td>
                    <td><?= $c['observacion'] ? esc($c['observacion']) : '<span class="text-muted">-</span>' ?></td>
                    <td><?= esc($c['usuario_nombre']) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>

      <!-- Tab: Ajustes -->
      <div class="tab-pane fade" id="ajustes" role="tabpanel">
        <?php if (empty($ajustes)): ?>
          <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No se han realizado ajustes manuales a los puntos de este cliente.
          </div>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0 table-styled">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Campaña</th>
                  <th>Antes</th>
                  <th>Después</th>
                  <th>Diferencia</th>
                  <th>Motivo</th>
                  <th>Por</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($ajustes as $a): ?>
                  <?php $diferencia = $a['puntos_despues'] - $a['puntos_antes']; ?>
                  <tr>
                    <td><?= date('d/m/Y H:i', strtotime($a['created_at'])) ?></td>
                    <td><?= esc($a['campania_nombre']) ?></td>
                    <td><?= number_format($a['puntos_antes']) ?></td>
                    <td><?= number_format($a['puntos_despues']) ?></td>
                    <td class="<?= $diferencia >= 0 ? 'text-success' : 'text-danger' ?> font-weight-bold">
                      <?= $diferencia >= 0 ? '+' : '' ?><?= number_format($diferencia) ?>
                    </td>
                    <td><?= esc($a['observacion']) ?></td>
                    <td><?= esc($a['usuario_nombre']) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>

      <!-- Tab: Historial General -->
      <div class="tab-pane fade" id="historial" role="tabpanel">
        <?php if (empty($movimientos)): ?>
          <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No hay movimientos registrados.
          </div>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0 table-styled" id="tablaPuntos">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Tipo</th>
                  <th>Puntos</th>
                  <th>Descripción</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($movimientos as $m): ?>
                  <?php
                    // Determinar el tipo de movimiento
                    $tipo = trim($m['tipo'] ?? '');
                    $tipoUpper = strtoupper($tipo);
                    $esPositivo = in_array($tipoUpper, ['GANADO', 'ACUMULADO', 'AJUSTE_POSITIVO', 'MIGRACION_ENTRADA']);
                    $esAjuste = in_array($tipoUpper, ['AJUSTE_POSITIVO', 'AJUSTE_NEGATIVO']);
                    $esCanje = in_array($tipoUpper, ['CANJEADO', 'CANJE']);

                    // Determinar badge según tipo
                    // Verde = Ganado, Azul = Canje, Amarillo = Ajuste
                    if ($esPositivo && !$esAjuste) {
                        $badgeClass = 'badge-success';
                        $badgeText = 'Ganado';
                    } elseif ($esCanje) {
                        $badgeClass = 'badge-info';
                        $badgeText = 'Canjeado';
                    } elseif ($esAjuste) {
                        $badgeClass = 'badge-warning';
                        $badgeText = $tipoUpper === 'AJUSTE_POSITIVO' ? 'Ajuste (+)' : 'Ajuste (-)';
                    } else {
                        $badgeClass = 'badge-secondary';
                        $badgeText = !empty($tipo) ? ucfirst(strtolower($tipo)) : 'Sin tipo';
                    }
                  ?>
                  <tr>
                    <td><?= date('d/m/Y H:i', strtotime($m['created_at'])) ?></td>
                    <td>
                      <span class="badge <?= $badgeClass ?>"><?= $badgeText ?></span>
                    </td>
                    <td class="<?= $esPositivo ? 'text-success' : 'text-danger' ?> font-weight-bold">
                      <?= $esPositivo ? '+' : '-' ?><?= number_format(abs($m['puntos'])) ?>
                    </td>
                    <td><?= esc($m['descripcion']) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
  $('#tablaPuntos').DataTable({
    language: {
      url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
    },
    order: [[0, 'desc']],
    pageLength: 25
  });
});
</script>
<?= $this->endSection() ?>
