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
    height: 100%;
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
    font-size: 0.85rem;
    font-weight: 500;
    opacity: 0.9;
    margin-bottom: 10px;
  }

  .stats-card-body h3 {
    font-size: 1.75rem;
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

  .filter-section label {
    color: #1A6BA8;
    font-weight: 600;
    margin-bottom: 5px;
    font-size: 0.9rem;
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

  .chart-container h4 {
    font-size: 1.1rem;
  }

  #filtroActivo {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    border: none;
  }

  /* Responsive adjustments */
  @media (max-width: 991.98px) {
    .stats-card-body h3 {
      font-size: 1.5rem;
    }
    .stats-card-body h6 {
      font-size: 0.8rem;
    }
  }

  @media (max-width: 767.98px) {
    .dashboard-card-header {
      padding: 14px 18px;
    }
    .dashboard-card-header h2 {
      font-size: 1.2rem;
    }
    .filter-section {
      padding: 15px;
    }
    .chart-container {
      padding: 15px;
    }
    .chart-container h4 {
      font-size: 1rem;
    }
    .btn-filtrar, .btn-limpiar {
      padding: 8px 16px;
      font-size: 0.9rem;
    }
    .btn-exportar {
      width: 100%;
      text-align: center;
    }
  }

  @media (max-width: 575.98px) {
    .stats-card-body {
      padding: 15px;
    }
    .stats-card-body h3 {
      font-size: 1.3rem;
    }
    .stats-card-body h6 {
      font-size: 0.75rem;
    }
  }
</style>

<div class="dashboard-card">
  <div class="dashboard-card-header">
    <h2><i class="fas fa-chart-line mr-2"></i>Dashboard</h2>
  </div>
</div>




<div class="filter-section">
  <div class="row g-3 mb-3">
    <div class="col-12 col-sm-6 col-lg-3">
      <label class="form-label">Fecha Inicio</label>
      <input type="date" id="fechaInicio" class="form-control">
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
      <label class="form-label">Fecha Fin</label>
      <input type="date" id="fechaFin" class="form-control">
    </div>
    <div class="col-12 col-sm-6 col-lg-2">
      <label class="form-label">Agrupación</label>
      <select id="tipoAgrupacion" class="form-control">
        <option value="dia" selected>Por Día</option>
        <option value="mes">Por Mes</option>
      </select>
    </div>
    <div class="col-6 col-sm-3 col-lg-2 d-flex align-items-end">
      <button id="btnFiltrar" class="btn btn-filtrar w-100 mt-3">
        <i class="fas fa-filter mr-1"></i> Filtrar
      </button>
    </div>
    <div class="col-6 col-sm-3 col-lg-2 d-flex align-items-end">
      <button id="btnLimpiarFiltros" class="btn btn-limpiar w-100" style="display:none;">
        <i class="fas fa-times-circle mr-1"></i> Limpiar
      </button>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div id="filtroActivo" class="alert" role="alert" style="display:none; padding: 1rem 1.5rem; font-size: 1.1rem; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <i class="fas fa-filter"></i> <strong>Filtrando datos</strong><span id="rangoFechas"></span>
      </div>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-6 col-md-6 col-lg-3">
    <div class="stats-card stats-card-primary">
      <div class="stats-card-body">
        <h6><i class="fas fa-users mr-1"></i>Total Clientes</h6>
        <h3><?= $totalClientes ?></h3>
      </div>
    </div>
  </div>

  <div class="col-6 col-md-6 col-lg-3">
    <div class="stats-card stats-card-success">
      <div class="stats-card-body">
        <h6><i class="fas fa-coins mr-1"></i>Puntos Totales</h6>
        <h3><?= $puntosTotales ?></h3>
      </div>
    </div>
  </div>

  <div class="col-6 col-md-6 col-lg-3">
    <div class="stats-card stats-card-warning">
      <div class="stats-card-body">
        <h6><i class="fas fa-star mr-1"></i>Puntos Hoy</h6>
        <h3><?= $puntosHoy ?></h3>
      </div>
    </div>
  </div>

  <div class="col-6 col-md-6 col-lg-3">
    <div class="stats-card stats-card-info">
      <div class="stats-card-body">
        <h6><i class="fas fa-shopping-cart mr-1"></i>Compras hoy</h6>
        <h3><?= $totalComprasHoy ?></h3>
      </div>
    </div>
  </div>
</div>


<div class="row g-3">
  <div class="col-12">
    <div class="chart-container">
      <div id="chartPuntos" style="height:350px; min-height:280px;"></div>
      <button class="btn btn-exportar" id="exportPuntos">
        <i class="fas fa-download mr-1"></i> Exportar Gráfico de Puntos
      </button>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-12">
    <div class="chart-container">
      <div id="chartCompras" style="height:350px; min-height:280px;"></div>
      <button class="btn btn-exportar" id="exportCompras">
        <i class="fas fa-download mr-1"></i> Exportar Gráfico de Compras
      </button>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-12">
    <div class="chart-container">
      <div id="chartTopClientes" style="height:350px; min-height:280px;"></div>
      <button class="btn btn-exportar" id="exportTopClientes">
        <i class="fas fa-download mr-1"></i> Exportar Gráfico de Top Clientes
      </button>
    </div>
  </div>
</div>

<!-- NUEVOS GRÁFICOS -->

<!-- Fila de tarjetas KPIs adicionales -->
<div class="row g-3 mb-4">
  <div class="col-6 col-md-6 col-lg-3">
    <div class="stats-card" style="background: linear-gradient(135deg, #e83e8c 0%, #f06595 100%); color: #fff;">
      <div class="stats-card-body">
        <h6><i class="fas fa-gift mr-1"></i>Total Canjes</h6>
        <h3 id="kpiTotalCanjes">-</h3>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-6 col-lg-3">
    <div class="stats-card" style="background: linear-gradient(135deg, #6f42c1 0%, #8b5cf6 100%); color: #fff;">
      <div class="stats-card-body">
        <h6><i class="fas fa-exchange-alt mr-1"></i>Pts Canjeados</h6>
        <h3 id="kpiPuntosCanjeados">-</h3>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-6 col-lg-3">
    <div class="stats-card" style="background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%); color: #fff;">
      <div class="stats-card-body">
        <h6><i class="fas fa-dollar-sign mr-1"></i>Monto Compras</h6>
        <h3 id="kpiMontoTotal">-</h3>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-6 col-lg-3">
    <div class="stats-card" style="background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%); color: #fff;">
      <div class="stats-card-body">
        <h6><i class="fas fa-user-check mr-1"></i>Prom. Pts/Cliente</h6>
        <h3 id="kpiPromedioCliente">-</h3>
      </div>
    </div>
  </div>
</div>

<!-- Gráficos de Pastel y Dona -->
<div class="row g-3">
  <div class="col-12 col-lg-6">
    <div class="chart-container">
      <h4 style="color: #1A6BA8; font-weight: 600; margin-bottom: 15px;">
        <i class="fas fa-chart-pie mr-2"></i>Distribución de Movimientos
      </h4>
      <div id="chartDistribucionTipos" style="height:300px; min-height:250px;"></div>
      <button class="btn btn-exportar" id="exportDistribucionTipos">
        <i class="fas fa-download mr-1"></i> Exportar Distribución
      </button>
    </div>
  </div>
  <div class="col-12 col-lg-6">
    <div class="chart-container">
      <h4 style="color: #1A6BA8; font-weight: 600; margin-bottom: 15px;">
        <i class="fas fa-ring mr-2"></i>Balance de Puntos
      </h4>
      <div id="chartComparativaPuntos" style="height:300px; min-height:250px;"></div>
      <button class="btn btn-exportar" id="exportComparativaPuntos">
        <i class="fas fa-download mr-1"></i> Exportar Balance
      </button>
    </div>
  </div>
</div>

<!-- Gráfico de Canjes -->
<div class="row g-3">
  <div class="col-12">
    <div class="chart-container">
      <h4 style="color: #1A6BA8; font-weight: 600; margin-bottom: 15px;">
        <i class="fas fa-gift mr-2"></i>Canjes Realizados
      </h4>
      <div id="chartCanjes" style="height:350px; min-height:280px;"></div>
      <button class="btn btn-exportar" id="exportCanjes">
        <i class="fas fa-download mr-1"></i> Exportar Gráfico de Canjes
      </button>
    </div>
  </div>
</div>

<!-- Gráfico de Montos de Compras -->
<div class="row g-3">
  <div class="col-12">
    <div class="chart-container">
      <h4 style="color: #1A6BA8; font-weight: 600; margin-bottom: 15px;">
        <i class="fas fa-money-bill-wave mr-2"></i>Montos de Compras (S/)
      </h4>
      <div id="chartMontoCompras" style="height:350px; min-height:280px;"></div>
      <button class="btn btn-exportar" id="exportMontoCompras">
        <i class="fas fa-download mr-1"></i> Exportar Gráfico de Montos
      </button>
    </div>
  </div>
</div>

<!-- Gráfico de Actividad por Hora y Campañas -->
<div class="row g-3">
  <div class="col-12 col-lg-6">
    <div class="chart-container">
      <h4 style="color: #1A6BA8; font-weight: 600; margin-bottom: 15px;">
        <i class="fas fa-clock mr-2"></i>Actividad por Hora del Día
      </h4>
      <div id="chartActividadHora" style="height:320px; min-height:260px;"></div>
      <button class="btn btn-exportar" id="exportActividadHora">
        <i class="fas fa-download mr-1"></i> Exportar Actividad por Hora
      </button>
    </div>
  </div>
  <div class="col-12 col-lg-6">
    <div class="chart-container">
      <h4 style="color: #1A6BA8; font-weight: 600; margin-bottom: 15px;">
        <i class="fas fa-bullhorn mr-2"></i>Puntos por Campaña
      </h4>
      <div id="chartCampanias" style="height:320px; min-height:260px;"></div>
      <button class="btn btn-exportar" id="exportCampanias">
        <i class="fas fa-download mr-1"></i> Exportar Campañas
      </button>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<script src="<?= base_url('js/dashboard/index.js') ?>"></script>
<?= $this->endSection() ?>
