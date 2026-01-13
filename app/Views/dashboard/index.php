<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
  .dashboard-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    margin-bottom: 20px;
  }

  .dashboard-card-header {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    padding: 18px 24px;
  }

  .dashboard-card-header h2 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
  }

  .stats-card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    margin-bottom: 20px;
  }

  .stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
  }

  .stats-card-primary {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
  }

  .stats-card-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: #fff;
  }

  .stats-card-warning {
    background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
    color: #fff;
  }

  .stats-card-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: #fff;
  }

  .stats-card-body {
    padding: 20px;
  }

  .stats-card-body h6 {
    font-size: 0.9rem;
    font-weight: 500;
    opacity: 0.9;
    margin-bottom: 10px;
  }

  .stats-card-body h3 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
  }

  .filter-section {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    margin-bottom: 20px;
  }

  .filter-section .form-control {
    border-radius: 8px;
    border: 1px solid #4A9DD9;
  }

  .filter-section .form-control:focus {
    border-color: #1A6BA8;
    box-shadow: 0 0 0 0.2rem rgba(26, 107, 168, 0.25);
  }

  .btn-filtrar {
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

  .btn-filtrar:hover {
    background: linear-gradient(90deg, #ff7a45 0%, #ffb319 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 107, 53, 0.3);
    color: #ffffff;
  }

  .btn-exportar {
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
    margin-top: 10px;
  }

  .btn-exportar:hover {
    background: linear-gradient(90deg, #ff7a45 0%, #ffb319 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 107, 53, 0.3);
    color: #ffffff;
  }

  .btn-limpiar {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 50px;
    padding: 10px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
  }

  .btn-limpiar:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(108, 117, 125, 0.3);
    color: #fff;
  }

  .chart-container {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    margin-bottom: 20px;
  }

  #filtroActivo {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    border: none;
  }
</style>

<div class="dashboard-card">
  <div class="dashboard-card-header">
    <h2><i class="fas fa-chart-line mr-2"></i>Dashboard</h2>
  </div>
</div>




<div class="filter-section">
  <div class="row mb-3">
    <div class="col-md-3">
      <label style="color: #1A6BA8; font-weight: 600; margin-bottom: 5px;">Fecha Inicio</label>
      <input type="date" id="fechaInicio" class="form-control">
    </div>
    <div class="col-md-3">
      <label style="color: #1A6BA8; font-weight: 600; margin-bottom: 5px;">Fecha Fin</label>
      <input type="date" id="fechaFin" class="form-control">
    </div>
    <div class="col-md-2">
      <label style="color: #1A6BA8; font-weight: 600; margin-bottom: 5px;">Agrupación</label>
      <select id="tipoAgrupacion" class="form-control">
        <option value="dia" selected>Por Día</option>
        <option value="mes">Por Mes</option>
      </select>
    </div>
    <div class="col-md-2 d-flex align-items-end">
      <button id="btnFiltrar" class="btn btn-filtrar w-100">
        <i class="fas fa-filter mr-1"></i> Filtrar
      </button>
    </div>
    <div class="col-md-2 d-flex align-items-end">
      <button id="btnLimpiarFiltros" class="btn btn-limpiar w-100" style="display:none;">
        <i class="fas fa-times-circle mr-1"></i> Limpiar
      </button>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div id="filtroActivo" class="alert" role="alert" style="display:none; padding: 1rem 1.5rem; font-size: 1.1rem; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <i class="fas fa-filter"></i> <strong>Filtrando datos</strong><span id="rangoFechas"></span>
      </div>
    </div>
  </div>
</div>

<div class="row mb-4">
  <div class="col-md-3">
    <div class="stats-card stats-card-primary">
      <div class="stats-card-body">
        <h6><i class="fas fa-users mr-1"></i>Total Clientes</h6>
        <h3><?= $totalClientes ?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="stats-card stats-card-success">
      <div class="stats-card-body">
        <h6><i class="fas fa-coins mr-1"></i>Puntos Totales</h6>
        <h3><?= $puntosTotales ?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="stats-card stats-card-warning">
      <div class="stats-card-body">
        <h6><i class="fas fa-star mr-1"></i>Puntos Hoy</h6>
        <h3><?= $puntosHoy ?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="stats-card stats-card-info">
      <div class="stats-card-body">
        <h6><i class="fas fa-shopping-cart mr-1"></i>Total de compras hoy</h6>
        <h3><?= $totalComprasHoy ?></h3>
      </div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-md-12">
    <div class="chart-container">
      <h4 style="color: #1A6BA8; font-weight: 600; margin-bottom: 15px;"><i class="fas fa-chart-area mr-2"></i>Puntos generados por día</h4>
      <div id="chartPuntos" style="height:400px;"></div>
      <button class="btn btn-exportar" id="exportPuntos">
        <i class="fas fa-download mr-1"></i> Exportar Gráfico de Puntos
      </button>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="chart-container">
      <h4 style="color: #1A6BA8; font-weight: 600; margin-bottom: 15px;"><i class="fas fa-chart-bar mr-2"></i>Compras realizadas</h4>
      <div id="chartCompras" style="height:400px;"></div>
      <button class="btn btn-exportar" id="exportCompras">
        <i class="fas fa-download mr-1"></i> Exportar Gráfico de Compras
      </button>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="chart-container">
      <h4 style="color: #1A6BA8; font-weight: 600; margin-bottom: 15px;"><i class="fas fa-trophy mr-2"></i>Top Clientes</h4>
      <div id="chartTopClientes" style="height:400px;"></div>
      <button class="btn btn-exportar" id="exportTopClientes">
        <i class="fas fa-download mr-1"></i> Exportar Gráfico de Top Clientes
      </button>
    </div>
  </div>
</div>

<!-- NUEVOS GRÁFICOS -->

<!-- Fila de tarjetas KPIs adicionales -->
<div class="row mb-4">
  <div class="col-md-3">
    <div class="stats-card" style="background: linear-gradient(135deg, #e83e8c 0%, #f06595 100%); color: #fff;">
      <div class="stats-card-body">
        <h6><i class="fas fa-gift mr-1"></i>Total Canjes</h6>
        <h3 id="kpiTotalCanjes">-</h3>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stats-card" style="background: linear-gradient(135deg, #6f42c1 0%, #8b5cf6 100%); color: #fff;">
      <div class="stats-card-body">
        <h6><i class="fas fa-exchange-alt mr-1"></i>Puntos Canjeados</h6>
        <h3 id="kpiPuntosCanjeados">-</h3>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stats-card" style="background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%); color: #fff;">
      <div class="stats-card-body">
        <h6><i class="fas fa-dollar-sign mr-1"></i>Monto Total Compras</h6>
        <h3 id="kpiMontoTotal">-</h3>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stats-card" style="background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%); color: #fff;">
      <div class="stats-card-body">
        <h6><i class="fas fa-user-check mr-1"></i>Promedio Pts/Cliente</h6>
        <h3 id="kpiPromedioCliente">-</h3>
      </div>
    </div>
  </div>
</div>

<!-- Gráficos de Pastel y Dona -->
<div class="row">
  <div class="col-md-6">
    <div class="chart-container">
      <h4 style="color: #1A6BA8; font-weight: 600; margin-bottom: 15px;">
        <i class="fas fa-chart-pie mr-2"></i>Distribución de Movimientos
      </h4>
      <div id="chartDistribucionTipos" style="height:350px;"></div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="chart-container">
      <h4 style="color: #1A6BA8; font-weight: 600; margin-bottom: 15px;">
        <i class="fas fa-ring mr-2"></i>Balance de Puntos
      </h4>
      <div id="chartComparativaPuntos" style="height:350px;"></div>
    </div>
  </div>
</div>

<!-- Gráfico de Canjes -->
<div class="row">
  <div class="col-md-12">
    <div class="chart-container">
      <h4 style="color: #1A6BA8; font-weight: 600; margin-bottom: 15px;">
        <i class="fas fa-gift mr-2"></i>Canjes Realizados
      </h4>
      <div id="chartCanjes" style="height:400px;"></div>
      <button class="btn btn-exportar" id="exportCanjes">
        <i class="fas fa-download mr-1"></i> Exportar Gráfico de Canjes
      </button>
    </div>
  </div>
</div>

<!-- Gráfico de Montos de Compras -->
<div class="row">
  <div class="col-md-12">
    <div class="chart-container">
      <h4 style="color: #1A6BA8; font-weight: 600; margin-bottom: 15px;">
        <i class="fas fa-money-bill-wave mr-2"></i>Montos de Compras (S/)
      </h4>
      <div id="chartMontoCompras" style="height:400px;"></div>
      <button class="btn btn-exportar" id="exportMontoCompras">
        <i class="fas fa-download mr-1"></i> Exportar Gráfico de Montos
      </button>
    </div>
  </div>
</div>

<!-- Gráfico de Actividad por Hora y Campañas -->
<div class="row">
  <div class="col-md-6">
    <div class="chart-container">
      <h4 style="color: #1A6BA8; font-weight: 600; margin-bottom: 15px;">
        <i class="fas fa-clock mr-2"></i>Actividad por Hora del Día
      </h4>
      <div id="chartActividadHora" style="height:380px;"></div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="chart-container">
      <h4 style="color: #1A6BA8; font-weight: 600; margin-bottom: 15px;">
        <i class="fas fa-bullhorn mr-2"></i>Puntos por Campaña
      </h4>
      <div id="chartCampanias" style="height:380px;"></div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<script src="<?= base_url('js/dashboard/index.js') ?>"></script>
<?= $this->endSection() ?>
