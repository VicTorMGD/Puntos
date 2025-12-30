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
    background: linear-gradient(135deg, #1B5E7C 0%, #87CEEB 100%);
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
    background: linear-gradient(135deg, #1B5E7C 0%, #87CEEB 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 999px;
    padding: 8px 18px;
    box-shadow: 0 4px 10px rgba(27, 94, 124, 0.4);
    transition: all 0.2s ease;
  }

  .btn-nuevo-usuario:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(27, 94, 124, 0.5);
    color: #fff;
  }

  .usuarios-card-body {
    background: linear-gradient(to bottom, #E0F4F8 0%, #ffffff 100%);
    padding: 18px 22px 22px;
  }

  #userTable {
    background-color: #ffffff;
    border-radius: 12px;
    overflow: hidden;
  }

  #userTable thead {
    background: linear-gradient(135deg, #1B5E7C 0%, #87CEEB 100%);
    color: #fff;
  }

  #userTable thead th {
    border-color: rgba(255, 255, 255, 0.2);
    font-weight: 600;
  }

  #userTable tbody tr:nth-child(even) {
    background-color: #F5FAFC;
  }

  #userTable tbody tr:hover {
    background-color: #E3F2F9;
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
</style>

<div class="card usuarios-card">
  <div class="usuarios-card-header">
    <h2><i class="fas fa-users-cog mr-2"></i>Gestión de Usuarios</h2>
    <a href="<?= base_url('users/create') ?>" class="btn btn-nuevo-usuario">
      <i class="fas fa-user-plus mr-1"></i> Nuevo Usuario
    </a>
  </div>

  <div class="usuarios-card-body">
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
