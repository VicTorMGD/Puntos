<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title><?= $title ?? 'Panel' ?></title>
  <link rel="stylesheet" href="<?= base_url('AdminLTE/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('AdminLTE/dist/css/adminlte.min.css') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro">
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a href="<?= base_url('logout') ?>" class="nav-link text-danger">Cerrar Sesión</a>
        </li>
      </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="<?= base_url('dashboard') ?>" class="brand-link">
        <span class="brand-text font-weight-light">Mi Tienda</span>
      </a>
      <div class="sidebar">
        <nav>
          <ul class="nav nav-pills nav-sidebar flex-column">
            <li class="nav-item">
              <a href="<?= base_url('categories') ?>" class="nav-link <?= uri_string() == 'categories' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-tags"></i>
                <p>Categorías</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('products') ?>" class="nav-link <?= uri_string() == 'products' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-box"></i>
                <p>Productos</p>
              </a>
            </li>

            <?php if (session()->get('role') === 'administrador'): ?>

              <li class="nav-item">
                <a href="<?= base_url('users') ?>" class="nav-link <?= uri_string() == 'users' ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Usuarios</p>
                </a>
              </li>
            <?php endif ?>


          </ul>
        </nav>
      </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper p-3">
      <?= $this->renderSection('content') ?>
    </div>
  </div>

  <!-- Scripts en el orden correcto -->
  <script src="<?= base_url('AdminLTE/plugins/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('AdminLTE/dist/js/adminlte.min.js') ?>"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Mostrar alertas desde sesión -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      <?php if (session('success')): ?>
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: '<?= session('success') ?>',
          confirmButtonColor: '#3085d6'
        });
      <?php elseif (session('error')): ?>
        Swal.fire({
          icon: 'error',
          title: 'Acceso denegado',
          text: '<?= session('error') ?>'
        });
      <?php endif; ?>
    });
  </script>

  <script>
    $(document).ready(function() {
      console.log("Inicializando DataTables");
      
      // Inicializar DataTable para productos
      if ($('#productTable').length) {
        $('#productTable').DataTable({
          language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
          },
          responsive: true,
          pageLength: 10,
          lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
        });
      }
      
      // Inicializar DataTable para categorías
      if ($('#categoryTable').length) {
        $('#categoryTable').DataTable({
          language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
          },
          responsive: true,
          pageLength: 10,
          lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
        });
      }
      
      // Inicializar DataTable para usuarios
      if ($('#userTable').length) {
        $('#userTable').DataTable({
          language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
          },
          responsive: true,
          pageLength: 10,
          lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
        });
      }
    });
  </script>

  <?= $this->renderSection('scripts') ?>

</body>

</html>