<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #105285 !important;">
  <a href="<?= base_url('inicio') ?>" class="brand-link">
    <div style="display: flex; align-items: center; justify-content: center; padding: 5px;">
      <div class="pharmalivet-brand-btn" style="display: flex; align-items: center; background: linear-gradient(90deg, #ff6b35 0%, #ffa500 100%); border-radius: 50px; padding: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); width: 100%; max-width: 280px; transition: all 0.3s ease;">
        <div style="width: 40px; height: 40px; border-radius: 50%; background-color: #ffffff; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
          <i class="fas fa-home" style="color: #ff6b35; font-size: 18px;"></i>
        </div>
        <span style="color: #ffffff; font-size: 1.2rem; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; letter-spacing: 0.5px;">
          PHARMALIVET
        </span>
      </div>
    </div>
    <div class="img-logo mt-2" style="display:flex;justify-content:center;">
      <img src="<?= base_url('assets/img/pharmalivet.png') ?>" alt="Logo" style="width: 50%; height: 50%; padding: 10px; margin: 15px; ">
    </div>
  </a>

  <div class="sidebar">
    <nav>
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

        <!-- Inicio -->
        <li class="nav-item">
          <a href="<?= base_url('inicio') ?>"
             class="nav-link <?= uri_string() == 'inicio' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-home"></i>
            <p>Inicio</p>
          </a>
        </li>

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="<?= base_url('dashboard') ?>"
             class="nav-link <?= uri_string() == 'dashboard' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- NUEVO: Puntos / Compras -->
        <li class="nav-item">
          <a href="<?= base_url('compras') ?>"
             class="nav-link <?= uri_string() == 'compras' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-coins"></i>
            <p>Compras / Puntos</p>
          </a>
        </li>

        <!-- NUEVO: Clientes -->
        <li class="nav-item">
          <a href="<?= base_url('clientes') ?>"
             class="nav-link <?= uri_string() == 'clientes' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user"></i>
            <p>Clientes</p>
          </a>
        </li>

        <!-- Canjes de Puntos -->
        <li class="nav-item">
          <a href="<?= base_url('canjes') ?>"
             class="nav-link <?= str_starts_with(uri_string(), 'canjes') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-gift"></i>
            <p>Canjes</p>
          </a>
        </li>

        <?php if (session()->get('role') === 'administrador'): ?>
          <!-- Campañas (solo admin) -->
          <li class="nav-item">
            <a href="<?= base_url('campanias') ?>"
               class="nav-link <?= str_starts_with(uri_string(), 'campanias') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-bullhorn"></i>
              <p>Campañas</p>
            </a>
          </li>

          <!-- Usuarios (solo admin) -->
          <li class="nav-item">
            <a href="<?= base_url('users') ?>"
               class="nav-link <?= uri_string() == 'users' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>Usuarios</p>
            </a>
          </li>

          <!-- Configuración (solo admin) -->
          <li class="nav-item">
            <a href="<?= base_url('configuracion') ?>"
               class="nav-link <?= uri_string() == 'configuracion' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-crow"></i>
              <p>Configuración</p>
            </a>
          </li>
        <?php endif; ?>

      </ul>
    </nav>
  </div>
  <div class="img-sidebar" style="display:flex;justify-content:center;">
    <img src="<?= base_url('assets/img/ranking.png') ?>" alt="Logo" style="width: 60%; height: 60%; padding: 0px; margin: 0px; ">
  </div>
</aside>
