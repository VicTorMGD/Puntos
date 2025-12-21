<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Categorías</h2>
<a href="<?= base_url('categories/create') ?>" class="btn btn-success mb-3">Nueva Categoría</a>

<table class="table table-bordered table-hover" id="categoryTable">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?= $cat['id'] ?></td>
                <td><?= esc($cat['name']) ?></td>
                <td>
                    <a href="<?= base_url('categories/edit/' . $cat['id']) ?>" class="btn btn-warning btn-sm">Editar</a>
                    <button class="btn btn-danger btn-sm btn-delete" data-url="<?= base_url('categories/delete/' . $cat['id']) ?>">
                        Eliminar
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