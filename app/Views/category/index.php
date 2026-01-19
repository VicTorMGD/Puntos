<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
  @media (max-width: 767.98px) {
    .page-header h2 { font-size: 1.3rem; }
    .btn-action { width: 100%; margin-bottom: 8px; }
    #categoryTable th:nth-child(1),
    #categoryTable td:nth-child(1) { display: none; }
  }
  @media (max-width: 575.98px) {
    .page-header h2 { font-size: 1.1rem; }
  }
</style>

<div class="page-header d-flex flex-wrap justify-content-between align-items-center mb-3">
  <h2 class="mb-2 mb-md-0">Categorías</h2>
  <a href="<?= base_url('categories/create') ?>" class="btn btn-success btn-action">Nueva Categoría</a>
</div>

<div class="table-responsive">
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