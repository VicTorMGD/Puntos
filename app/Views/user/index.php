<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Gestión de Usuarios</h2>

<a href="<?= base_url('users/create') ?>" class="btn btn-success mb-3">Nuevo Usuario</a>

<table class="table table-bordered table-hover" id="userTable">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= esc($u['name']) ?></td>
                <td><?= esc($u['email']) ?></td>
                <td><?= esc($u['role']) ?></td>
                <td>
                    <a href="<?= base_url('users/edit/' . $u['id']) ?>" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-danger btn-delete"
                            data-url="<?= base_url('users/delete/' . $u['id']) ?>">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

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
