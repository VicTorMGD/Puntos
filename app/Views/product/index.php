<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Productos</h2>
<a href="<?= base_url('products/create') ?>" class="btn btn-success mb-3">Nuevo Producto</a>

<a href="<?= base_url('export/products') ?>" class="btn btn-outline-primary mb-3">
    <i class="fas fa-file-excel"></i> Exportar a Excel
</a>
<a href="<?= base_url('export/products-pdf') ?>" class="btn btn-outline-danger mb-3">
    <i class="fas fa-file-pdf"></i> Exportar a PDF
</a>

<table class="table table-bordered table-hover" id="productTable">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= esc($p['name']) ?></td>
                <td><?= esc($p['category_name']) ?></td>
                <td>S/ <?= number_format($p['price'], 2) ?></td>
                <td>
                    <?php if ($p['image']): ?>
                        <img src="<?= base_url('uploads/' . $p['image']) ?>" width="60">
                    <?php else: ?>
                        <small>Sin imagen</small>
                    <?php endif ?>
                </td>
                <td>
                    <a href="<?= base_url('products/edit/' . $p['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-url="<?= base_url('products/delete/' . $p['id']) ?>">
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
