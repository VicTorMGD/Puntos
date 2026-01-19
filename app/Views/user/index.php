<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
  .usuarios-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
  }

  .usuarios-card-header {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .usuarios-card-header h2 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
  }

  .btn-nuevo-usuario {
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

  .btn-nuevo-usuario:hover {
    background: linear-gradient(90deg, #ff7a45 0%, #ffb319 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 107, 53, 0.3);
    color: #ffffff;
  }

  .usuarios-card-body {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
    padding: 18px 22px 22px;
  }

  #userTable {
    background-color: #ffffff;
    border-radius: 12px;
    overflow: hidden;
  }

  #userTable thead {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
  }

  #userTable thead th {
    border-color: rgba(255, 255, 255, 0.2);
    font-weight: 600;
  }

  #userTable tbody tr:nth-child(even) {
    background-color: #F0F7FB;
  }

  #userTable tbody tr:hover {
    background-color: #C8E0F0;
  }

  #userTable td,
  #userTable th {
    vertical-align: middle;
  }

  .btn-accion-editar {
    background: linear-gradient(135deg, #FFC107 0%, #FFB300 100%);
    border: none;
    color: #fff;
  }

  .btn-accion-eliminar {
    background: linear-gradient(135deg, #E53935 0%, #D32F2F 100%);
    border: none;
    color: #fff;
  }

  .usuarios-image-container {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 25px;
    margin-top: 25px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px;
    width: 100%;
  }

  .usuarios-image-container img {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain;
    border-radius: 10px;
    filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.15));
  }

  /* Responsive adjustments */
  @media (max-width: 991.98px) {
    .usuarios-card-header {
      flex-direction: column;
      gap: 12px;
      text-align: center;
    }
    .usuarios-card-header h2 {
      font-size: 1.25rem;
    }
  }

  @media (max-width: 767.98px) {
    .usuarios-card-header {
      padding: 14px 18px;
    }
    .usuarios-card-body {
      padding: 14px 16px;
    }
    .usuarios-image-container {
      padding: 15px;
      margin-top: 15px;
    }
    .usuarios-image-container img {
      max-height: 250px;
    }
    .btn-nuevo-usuario {
      padding: 10px 16px;
      font-size: 0.9rem;
    }
    #userTable thead th {
      font-size: 0.85rem;
      padding: 10px 8px;
    }
    #userTable tbody td {
      font-size: 0.85rem;
      padding: 10px 8px;
    }
    .btn-sm {
      padding: 0.35rem 0.5rem;
      font-size: 0.8rem;
    }
  }

  @media (max-width: 575.98px) {
    .usuarios-card-header h2 {
      font-size: 1.1rem;
    }
    .usuarios-image-container img {
      max-height: 180px;
    }
    #userTable thead th,
    #userTable tbody td {
      font-size: 0.8rem;
      padding: 8px 6px;
    }
  }
</style>

<div class="card usuarios-card">
  <div class="usuarios-card-header">
    <h2><i class="fas fa-users-cog mr-2"></i>Gestión de Usuarios</h2>
    <a href="<?= base_url('users/create') ?>" class="btn btn-nuevo-usuario">
      <i class="fas fa-user-plus mr-1"></i> Nuevo Usuario
    </a>
  </div>

  <div class="usuarios-card-body">
    <!-- Tabla de usuarios -->
    <div class="table-responsive">
      <table class="table table-bordered table-hover mb-0" id="userTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th class="text-center" style="width: 130px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $u): ?>
            <tr>
              <td><?= $u['id'] ?></td>
              <td><?= esc($u['name']) ?></td>
              <td><?= esc($u['email']) ?></td>
              <td><?= esc($u['role']) ?></td>
              <td class="text-center">
                <a href="<?= base_url('users/edit/' . $u['id']) ?>" class="btn btn-sm btn-accion-editar mr-1">
                  <i class="fas fa-edit"></i>
                </a>
                <button class="btn btn-sm btn-accion-eliminar btn-delete"
                        data-url="<?= base_url('users/delete/' . $u['id']) ?>">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>

    <!-- Imagen del frontis (ancho completo debajo de la tabla) -->
    <div class="row">
      <div class="col-12">
        <div class="usuarios-image-container">
          <img src="<?= base_url('assets/img/Frontis-framacia1.png') ?>" alt="Frontis de la Farmacia">
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function () {
    // SweetAlert2 para eliminación
    $('.btn-delete').on('click', function (e) {
        e.preventDefault();
        const url = $(this).data('url');

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
