<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title><?= $title ?? 'Pharmalivet' ?></title>
  <link rel="stylesheet" href="<?= base_url('AdminLTE/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('AdminLTE/dist/css/adminlte.min.css') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro">
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    /* Estilos responsive para el sidebar */

    /* En pantallas pequeñas (tablets y móviles) */
    @media (max-width: 991px) {
      /* Ocultar sidebar por defecto en móviles */
      body:not(.sidebar-open) .main-sidebar {
        margin-left: -250px;
      }

      /* Asegurar que el contenido ocupe todo el ancho cuando el sidebar está oculto */
      body:not(.sidebar-open) .content-wrapper {
        margin-left: 0 !important;
      }

      /* Cuando el sidebar está abierto, mostrarlo sobre el contenido (overlay) */
      body.sidebar-open .main-sidebar {
        margin-left: 0;
        position: fixed;
        height: 100vh;
        z-index: 1040;
        box-shadow: 3px 0 10px rgba(0, 0, 0, 0.3);
      }

      /* Overlay oscuro cuando el sidebar está abierto */
      body.sidebar-open::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1035;
      }

      /* El contenido principal se mantiene en su lugar */
      body.sidebar-open .content-wrapper {
        margin-left: 0 !important;
      }

      /* Transiciones suaves */
      .main-sidebar {
        transition: margin-left 0.3s ease-in-out;
      }
    }

    /* En pantallas grandes (desktop) */
    @media (min-width: 992px) {
      /* Sidebar siempre visible */
      .main-sidebar {
        margin-left: 0 !important;
      }

      /* Mostrar botón hamburguesa solo si se desea */
      body.sidebar-collapse .main-sidebar {
        margin-left: 0;
      }
    }

    /* Mejorar el botón hamburguesa */
    .navbar-nav .nav-link[data-widget="pushmenu"] {
      padding: 0.5rem 1rem;
    }

    .navbar-nav .nav-link[data-widget="pushmenu"] i {
      font-size: 1.2rem;
    }

    /* Estilos para el avatar mini en el header */
    .user-avatar-mini {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .user-avatar-mini:hover {
      transform: scale(1.1);
      box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    }

    .user-avatar-initials-mini {
      width: 35px;
      height: 35px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      font-size: 1rem;
      font-weight: bold;
      border-radius: 50%;
      border: 2px solid #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .user-avatar-initials-mini:hover {
      transform: scale(1.1);
      box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    }

    .user-name {
      font-weight: 500;
      color: #333;
    }

    /* Animación pulse suave para el avatar */
    @keyframes pulse-soft {
      0%, 100% {
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      }
      50% {
        box-shadow: 0 2px 15px rgba(102, 126, 234, 0.4);
      }
    }

    .user-avatar-mini,
    .user-avatar-initials-mini {
      animation: pulse-soft 3s ease-in-out infinite;
    }

    /* Dropdown menu styling */
    .dropdown-menu {
      border: none;
      box-shadow: 0 4px 20px rgba(0,0,0,0.15);
      border-radius: 8px;
    }

    .dropdown-item {
      padding: 10px 20px;
      transition: background-color 0.2s ease;
    }

    .dropdown-item:hover {
      background-color: #f8f9fa;
    }

    .dropdown-item.text-danger:hover {
      background-color: #fff5f5;
    }
  </style>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Botón hamburguesa para móviles -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
          </a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <!-- Dropdown de usuario -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php
              $currentUser = $currentUser ?? null;
              $userName = $currentUser['name'] ?? session()->get('name') ?? 'Usuario';
              $userAvatar = $currentUser['avatar'] ?? null;
              $initials = strtoupper(substr($userName, 0, 1));
            ?>
            <?php if ($userAvatar && file_exists(WRITEPATH . 'uploads/avatars/' . $userAvatar)): ?>
              <img src="<?= base_url('uploads/avatars/' . $userAvatar) ?>"
                   class="user-avatar-mini"
                   alt="Avatar">
            <?php else: ?>
              <span class="user-avatar-initials-mini"><?= $initials ?></span>
            <?php endif; ?>
            <span class="ml-2 d-none d-md-inline user-name"><?= esc($userName) ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="<?= base_url('perfil') ?>">
              <i class="fas fa-user-circle mr-2"></i> Mi Perfil
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
              <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
            </a>
          </div>
        </li>
      </ul>
    </nav>

    <?= $this->include('partials/sidebar') ?>


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

  <script>
    // Variables globales para JavaScript
    const BASE_URL = '<?= base_url() ?>/';
    const CSRF_TOKEN_NAME = '<?= csrf_token() ?>';
    const CSRF_TOKEN_VALUE = '<?= csrf_hash() ?>';
  </script>

  <script>
    // Control del sidebar responsive
    $(document).ready(function() {
      // Función para cerrar el sidebar en móviles al hacer clic fuera de él
      function closeSidebarOnMobile() {
        if (window.innerWidth <= 991) {
          $('body').removeClass('sidebar-open');
        }
      }

      // Manejar el clic en el botón hamburguesa
      $('[data-widget="pushmenu"]').on('click', function(e) {
        e.preventDefault();

        if (window.innerWidth <= 991) {
          // En móviles, toggle de la clase sidebar-open
          $('body').toggleClass('sidebar-open');
        } else {
          // En desktop, usar el comportamiento normal de AdminLTE
          $('body').toggleClass('sidebar-collapse');
        }
      });

      // Cerrar sidebar al hacer clic en el overlay (en móviles)
      $('body').on('click', function(e) {
        if (window.innerWidth <= 991 && $('body').hasClass('sidebar-open')) {
          // Si se hace clic fuera del sidebar y del botón hamburguesa
          if (!$(e.target).closest('.main-sidebar').length &&
              !$(e.target).closest('[data-widget="pushmenu"]').length) {
            $('body').removeClass('sidebar-open');
          }
        }
      });

      // Cerrar sidebar al hacer clic en un enlace del menú (en móviles)
      $('.main-sidebar .nav-link').on('click', function() {
        if (window.innerWidth <= 991) {
          setTimeout(function() {
            $('body').removeClass('sidebar-open');
          }, 300);
        }
      });

      // Ajustar al redimensionar la ventana
      $(window).on('resize', function() {
        if (window.innerWidth > 991) {
          // En desktop, remover la clase sidebar-open
          $('body').removeClass('sidebar-open');
        }
      });
    });
  </script>

  <?= $this->renderSection('scripts') ?>

</body>

</html>