<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="<?= base_url('dashboard') ?>" class="brand-link">
    <span class="brand-text font-weight-light" style="display:flex;justify-content:center;">
      Mi Tienda
    </span>
  </a>

  <div class="sidebar">
    <nav>
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

        <!-- Categorías 
        <li class="nav-item">
          <a href="<?= base_url('categories') ?>"
             class="nav-link <?= uri_string() == 'categories' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tags"></i>
            <p>Categorías</p>
          </a>
        </li> -->

        <!-- Productos 
        <li class="nav-item">
          <a href="<?= base_url('products') ?>"
             class="nav-link <?= uri_string() == 'products' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-box"></i>
            <p>Productos</p>
          </a>
        </li> -->

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

        <?php if (session()->get('role') === 'administrador'): ?>
          <li class="nav-item">
            <a href="<?= base_url('users') ?>"
               class="nav-link <?= uri_string() == 'users' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>Usuarios</p>
            </a>
          </li>
        <?php endif; ?>

      </ul>
    </nav>
  </div>
</aside>
