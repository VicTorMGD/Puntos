<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
  /* ============================================
     ESTILOS GENERALES DE LA VISTA DE INICIO
     ============================================ */

  .inicio-container {
    min-height: calc(100vh - 150px);
  }

  .inicio-row {
    display: flex;
    gap: 24px;
    margin-bottom: 24px;
  }

  .inicio-col-welcome {
    flex: 0 0 66.666%;
    max-width: 66.666%;
  }

  .inicio-col-shortcuts {
    flex: 0 0 calc(33.333% - 24px);
    max-width: calc(33.333% - 24px);
  }

  /* ============================================
     SECCIÓN DE BIENVENIDA (HERO)
     ============================================ */

  .welcome-hero {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 50%, #1A6BA8 100%);
    border-radius: 20px;
    padding: 35px;
    height: 100%;
    position: relative;
    overflow: hidden;
    box-shadow: 0 12px 30px rgba(26, 107, 168, 0.3);
  }

  .welcome-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 60%;
    height: 200%;
    background: radial-gradient(ellipse, rgba(255,255,255,0.1) 0%, transparent 70%);
    transform: rotate(-15deg);
  }

  .welcome-hero::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 40%;
    height: 150%;
    background: radial-gradient(ellipse, rgba(255,107,53,0.15) 0%, transparent 60%);
    transform: rotate(20deg);
  }

  .welcome-content {
    position: relative;
    z-index: 2;
  }

  .welcome-inner-row {
    display: flex;
    align-items: center;
    gap: 20px;
  }

  .welcome-text-col {
    flex: 0 0 70%;
    max-width: 70%;
  }

  .welcome-image-col {
    flex: 0 0 30%;
    max-width: 30%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .welcome-image-col img {
    max-width: 100%;
    max-height: 250px;
    object-fit: contain;
    filter: drop-shadow(0 8px 20px rgba(0, 0, 0, 0.2));
  }

  @media (max-width: 768px) {
    .welcome-inner-row {
      flex-direction: column;
    }
    .welcome-text-col,
    .welcome-image-col {
      flex: 0 0 100%;
      max-width: 100%;
    }
    .welcome-image-col {
      margin-top: 20px;
    }
    .welcome-image-col img {
      max-height: 150px;
    }
  }

  .welcome-greeting {
    color: rgba(255,255,255,0.9);
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .welcome-greeting .wave {
    display: inline-block;
    animation: wave 2.5s infinite;
    transform-origin: 70% 70%;
    font-size: 1.3rem;
  }

  @keyframes wave {
    0%, 100% { transform: rotate(0deg); }
    10%, 30% { transform: rotate(14deg); }
    20% { transform: rotate(-8deg); }
    40% { transform: rotate(14deg); }
    50%, 100% { transform: rotate(0deg); }
  }

  .welcome-name {
    color: #ffffff;
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 12px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.2);
  }

  .welcome-subtitle {
    color: rgba(255,255,255,0.95);
    font-size: 1.05rem;
    font-weight: 400;
    line-height: 1.6;
    max-width: 550px;
  }

  .welcome-subtitle .brand-highlight {
    background: linear-gradient(90deg, #ff6b35 0%, #ffa500 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
  }

  .welcome-stats {
    display: flex;
    gap: 15px;
    margin-top: 20px;
    flex-wrap: wrap;
  }

  .welcome-stat {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    border-radius: 14px;
    padding: 12px 18px;
    border: 1px solid rgba(255,255,255,0.2);
    min-width: 120px;
    text-align: center;
  }

  .welcome-stat-value {
    color: #ffffff;
    font-size: 1.6rem;
    font-weight: 700;
  }

  .welcome-stat-label {
    color: rgba(255,255,255,0.8);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  /* ============================================
     PANEL DE ACCESOS DIRECTOS (SIDEBAR)
     ============================================ */

  .shortcuts-panel {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 20px;
    padding: 20px;
    height: 100%;
    border: 1px solid #e9ecef;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
  }

  .shortcuts-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 2px solid #e9ecef;
  }

  .shortcuts-header-icon {
    width: 38px;
    height: 38px;
    background: linear-gradient(135deg, #ff6b35 0%, #ffa500 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .shortcuts-header-icon i {
    color: #ffffff;
    font-size: 1rem;
  }

  .shortcuts-header h3 {
    color: #1A6BA8;
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
  }

  .shortcuts-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  /* ============================================
     TARJETAS DE ACCESO DIRECTO (COMPACTAS)
     ============================================ */

  .shortcut-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .shortcut-item:hover {
    transform: translateX(5px);
    text-decoration: none;
  }

  .shortcut-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    border-radius: 0 4px 4px 0;
    transition: width 0.3s ease;
  }

  .shortcut-item:hover::before {
    width: 6px;
  }

  /* Colores por tipo */
  .shortcut-compras {
    background: linear-gradient(135deg, rgba(255,107,53,0.1) 0%, rgba(255,165,0,0.1) 100%);
  }
  .shortcut-compras::before { background: linear-gradient(180deg, #ff6b35, #ffa500); }
  .shortcut-compras:hover { background: linear-gradient(135deg, rgba(255,107,53,0.18) 0%, rgba(255,165,0,0.18) 100%); }

  .shortcut-clientes {
    background: linear-gradient(135deg, rgba(26,107,168,0.1) 0%, rgba(74,157,217,0.1) 100%);
  }
  .shortcut-clientes::before { background: linear-gradient(180deg, #1A6BA8, #4A9DD9); }
  .shortcut-clientes:hover { background: linear-gradient(135deg, rgba(26,107,168,0.18) 0%, rgba(74,157,217,0.18) 100%); }

  .shortcut-canjes {
    background: linear-gradient(135deg, rgba(40,167,69,0.1) 0%, rgba(52,199,89,0.1) 100%);
  }
  .shortcut-canjes::before { background: linear-gradient(180deg, #28a745, #34c759); }
  .shortcut-canjes:hover { background: linear-gradient(135deg, rgba(40,167,69,0.18) 0%, rgba(52,199,89,0.18) 100%); }

  .shortcut-dashboard {
    background: linear-gradient(135deg, rgba(111,66,193,0.1) 0%, rgba(139,92,246,0.1) 100%);
  }
  .shortcut-dashboard::before { background: linear-gradient(180deg, #6f42c1, #8b5cf6); }
  .shortcut-dashboard:hover { background: linear-gradient(135deg, rgba(111,66,193,0.18) 0%, rgba(139,92,246,0.18) 100%); }

  .shortcut-campanias {
    background: linear-gradient(135deg, rgba(232,62,140,0.1) 0%, rgba(240,101,149,0.1) 100%);
  }
  .shortcut-campanias::before { background: linear-gradient(180deg, #e83e8c, #f06595); }
  .shortcut-campanias:hover { background: linear-gradient(135deg, rgba(232,62,140,0.18) 0%, rgba(240,101,149,0.18) 100%); }

  .shortcut-icon-box {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: transform 0.3s ease;
  }

  .shortcut-item:hover .shortcut-icon-box {
    transform: scale(1.1);
  }

  .shortcut-compras .shortcut-icon-box { background: linear-gradient(135deg, #ff6b35, #ffa500); }
  .shortcut-clientes .shortcut-icon-box { background: linear-gradient(135deg, #1A6BA8, #4A9DD9); }
  .shortcut-canjes .shortcut-icon-box { background: linear-gradient(135deg, #28a745, #34c759); }
  .shortcut-dashboard .shortcut-icon-box { background: linear-gradient(135deg, #6f42c1, #8b5cf6); }
  .shortcut-campanias .shortcut-icon-box { background: linear-gradient(135deg, #e83e8c, #f06595); }

  .shortcut-icon-box i {
    color: #ffffff;
    font-size: 1.1rem;
  }

  .shortcut-info {
    flex-grow: 1;
    min-width: 0;
  }

  .shortcut-title {
    color: #343a40;
    font-size: 0.95rem;
    font-weight: 600;
    margin: 0 0 2px 0;
  }

  .shortcut-desc {
    color: #6c757d;
    font-size: 0.75rem;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .shortcut-badge {
    background: rgba(0,0,0,0.08);
    color: #495057;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    flex-shrink: 0;
  }

  .shortcut-arrow {
    color: #adb5bd;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    flex-shrink: 0;
  }

  .shortcut-item:hover .shortcut-arrow {
    color: #495057;
    transform: translateX(3px);
  }

  /* ============================================
     SECCIÓN INFO CAMPAÑA ACTIVA
     ============================================ */

  .campaign-info-box {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 18px;
    padding: 22px 28px;
    border: 2px solid #e9ecef;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
  }

  .campaign-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
  }

  .campaign-left {
    display: flex;
    align-items: center;
    gap: 15px;
  }

  .campaign-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #28a745 0%, #34c759 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .campaign-icon i {
    color: #ffffff;
    font-size: 1.3rem;
  }

  .campaign-text h4 {
    color: #1A6BA8;
    font-size: 0.9rem;
    font-weight: 500;
    margin: 0 0 3px 0;
  }

  .campaign-text h3 {
    color: #28a745;
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0;
  }

  .campaign-details {
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
  }

  .campaign-detail {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #495057;
    font-size: 0.9rem;
    background: #f8f9fa;
    padding: 8px 14px;
    border-radius: 10px;
  }

  .campaign-detail i {
    color: #ff6b35;
  }

  .campaign-warning {
    border-color: #ffc107;
  }

  .campaign-warning .campaign-icon {
    background: linear-gradient(135deg, #ffc107 0%, #ffca2c 100%);
  }

  .campaign-warning .campaign-text h3 {
    color: #856404;
  }

  /* ============================================
     RESPONSIVE
     ============================================ */

  @media (max-width: 992px) {
    .inicio-row {
      flex-direction: column;
    }

    .inicio-col-welcome,
    .inicio-col-shortcuts {
      flex: 0 0 100%;
      max-width: 100%;
    }

    .shortcuts-panel {
      height: auto;
    }

    .shortcuts-list {
      flex-direction: row;
      flex-wrap: wrap;
    }

    .shortcut-item {
      flex: 1 1 calc(50% - 5px);
      min-width: 200px;
    }
  }

  @media (max-width: 576px) {
    .welcome-hero {
      padding: 25px 20px;
    }

    .welcome-name {
      font-size: 1.7rem;
    }

    .welcome-subtitle {
      font-size: 0.95rem;
    }

    .welcome-stats {
      gap: 10px;
    }

    .welcome-stat {
      padding: 10px 14px;
      min-width: 100px;
    }

    .welcome-stat-value {
      font-size: 1.3rem;
    }

    .shortcut-item {
      flex: 1 1 100%;
    }

    .campaign-content {
      flex-direction: column;
      align-items: flex-start;
    }
  }
</style>

<div class="inicio-container">
  <!-- Fila Principal: Bienvenida + Accesos Rápidos -->
  <div class="inicio-row">
    <!-- Columna Izquierda: Bienvenida (8 de 12) -->
    <div class="inicio-col-welcome">
      <div class="welcome-hero">
        <div class="welcome-content">
          <div class="welcome-inner-row">
            <!-- Columna de texto (70%) -->
            <div class="welcome-text-col">
              <div class="welcome-greeting">
                <span class="wave">👋</span>
                <span>¡Hola, bienvenido!</span>
              </div>
              <h1 class="welcome-name"><?= esc(session()->get('name') ?? 'Usuario') ?></h1>
              <p class="welcome-subtitle">
                Sistema de Acumulación y Canje de Puntos desarrollado exclusivamente para
                <span class="brand-highlight">PHARMALIVET</span>.
                Gestiona clientes, registra compras y administra recompensas de manera eficiente.
              </p>

              <div class="welcome-stats">
                <div class="welcome-stat">
                  <div class="welcome-stat-value"><?= number_format($totalClientes) ?></div>
                  <div class="welcome-stat-label">Clientes Activos</div>
                </div>
                <div class="welcome-stat">
                  <div class="welcome-stat-value"><?= number_format($comprasHoy) ?></div>
                  <div class="welcome-stat-label">Compras Hoy</div>
                </div>
                <div class="welcome-stat">
                  <div class="welcome-stat-value"><?= number_format($canjesHoy) ?></div>
                  <div class="welcome-stat-label">Canjes Hoy</div>
                </div>
              </div>
            </div>

            <!-- Columna de imagen (30%) -->
            <div class="welcome-image-col">
              <img src="<?= base_url('assets/img/farmaceutica3.png') ?>" alt="Ilustración farmacéutica">
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Columna Derecha: Accesos Rápidos (4 de 12) -->
    <div class="inicio-col-shortcuts">
      <div class="shortcuts-panel">
        <div class="shortcuts-header">
          <div class="shortcuts-header-icon">
            <i class="fas fa-rocket"></i>
          </div>
          <h3>Accesos Rápidos</h3>
        </div>

        <div class="shortcuts-list">
          <!-- Compras / Puntos -->
          <a href="<?= base_url('compras') ?>" class="shortcut-item shortcut-compras">
            <div class="shortcut-icon-box">
              <i class="fas fa-coins"></i>
            </div>
            <div class="shortcut-info">
              <h4 class="shortcut-title">Compras / Puntos</h4>
              <p class="shortcut-desc">Registrar compras</p>
            </div>
            <?php if ($comprasHoy > 0): ?>
              <span class="shortcut-badge"><?= $comprasHoy ?></span>
            <?php endif; ?>
            <i class="fas fa-chevron-right shortcut-arrow"></i>
          </a>

          <!-- Clientes -->
          <a href="<?= base_url('clientes') ?>" class="shortcut-item shortcut-clientes">
            <div class="shortcut-icon-box">
              <i class="fas fa-users"></i>
            </div>
            <div class="shortcut-info">
              <h4 class="shortcut-title">Clientes</h4>
              <p class="shortcut-desc">Gestionar clientes</p>
            </div>
            <span class="shortcut-badge"><?= number_format($totalClientes) ?></span>
            <i class="fas fa-chevron-right shortcut-arrow"></i>
          </a>

          <!-- Canjes -->
          <a href="<?= base_url('canjes') ?>" class="shortcut-item shortcut-canjes">
            <div class="shortcut-icon-box">
              <i class="fas fa-gift"></i>
            </div>
            <div class="shortcut-info">
              <h4 class="shortcut-title">Canje de Puntos</h4>
              <p class="shortcut-desc">Procesar canjes</p>
            </div>
            <?php if ($canjesHoy > 0): ?>
              <span class="shortcut-badge"><?= $canjesHoy ?></span>
            <?php endif; ?>
            <i class="fas fa-chevron-right shortcut-arrow"></i>
          </a>

          <!-- Dashboard -->
          <a href="<?= base_url('dashboard') ?>" class="shortcut-item shortcut-dashboard">
            <div class="shortcut-icon-box">
              <i class="fas fa-chart-line"></i>
            </div>
            <div class="shortcut-info">
              <h4 class="shortcut-title">Dashboard</h4>
              <p class="shortcut-desc">Ver estadísticas</p>
            </div>
            <i class="fas fa-chevron-right shortcut-arrow"></i>
          </a>

          <?php if ($userRole === 'administrador'): ?>
          <!-- Campañas (Solo Admin) -->
          <a href="<?= base_url('campanias') ?>" class="shortcut-item shortcut-campanias">
            <div class="shortcut-icon-box">
              <i class="fas fa-bullhorn"></i>
            </div>
            <div class="shortcut-info">
              <h4 class="shortcut-title">Campañas</h4>
              <p class="shortcut-desc">Configurar reglas</p>
            </div>
            <span class="shortcut-badge">Admin</span>
            <i class="fas fa-chevron-right shortcut-arrow"></i>
          </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Info Campaña Activa -->
  <?php if ($campaniaActiva): ?>
  <div class="campaign-info-box">
    <div class="campaign-content">
      <div class="campaign-left">
        <div class="campaign-icon">
          <i class="fas fa-flag-checkered"></i>
        </div>
        <div class="campaign-text">
          <h4>Campaña Activa</h4>
          <h3><?= esc($campaniaActiva['nombre']) ?></h3>
        </div>
      </div>
      <div class="campaign-details">
        <div class="campaign-detail">
          <i class="fas fa-dollar-sign"></i>
          <span>Cada S/ <?= number_format($campaniaActiva['monto_base'], 2) ?></span>
        </div>
        <div class="campaign-detail">
          <i class="fas fa-star"></i>
          <span><?= $campaniaActiva['puntos_por_monto'] ?> puntos</span>
        </div>
        <?php if ($campaniaActiva['puntos_dobles_finsemana']): ?>
        <div class="campaign-detail">
          <i class="fas fa-calendar-week"></i>
          <span>Puntos dobles fines de semana</span>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php else: ?>
  <div class="campaign-info-box campaign-warning">
    <div class="campaign-content">
      <div class="campaign-left">
        <div class="campaign-icon">
          <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="campaign-text">
          <h4>Sin Campaña Activa</h4>
          <h3>No hay campaña configurada</h3>
        </div>
      </div>
      <?php if ($userRole === 'administrador'): ?>
      <a href="<?= base_url('campanias/crear') ?>" class="btn btn-warning">
        <i class="fas fa-plus mr-1"></i> Crear Nueva Campaña
      </a>
      <?php endif; ?>
    </div>
  </div>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>
