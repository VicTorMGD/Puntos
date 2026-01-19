<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
  /* Estilos responsive para productos */
  @media (max-width: 767.98px) {
    .page-header h2 {
      font-size: 1.3rem;
    }
    .btn-action {
      width: 100%;
      margin-bottom: 8px;
    }
    #productTable th:nth-child(1),
    #productTable td:nth-child(1) {
      display: none;
    }
  }
  @media (max-width: 575.98px) {
    .page-header h2 {
      font-size: 1.1rem;
    }
    #productTable th:nth-child(4),
    #productTable td:nth-child(4),
    #productTable th:nth-child(5),
    #productTable td:nth-child(5) {
      display: none;
    }
  }
</style>

<div class="page-header d-flex flex-wrap justify-content-between align-items-center mb-3">
  <h2 class="mb-2 mb-md-0">Productos</h2>
  <div class="d-flex flex-wrap gap-2">
    <a href="<?= base_url('products/create') ?>" class="btn btn-success btn-action">Nuevo Producto</a>
    <a href="<?= base_url('export/products') ?>" class="btn btn-outline-primary btn-action">
      <i class="fas fa-file-excel"></i> Exportar a Excel
    </a>
    <a href="<?= base_url('export/products-pdf') ?>" class="btn btn-outline-danger btn-action">
      <i class="fas fa-file-pdf"></i> Exportar a PDF
    </a>
  </div>
</div>

<div class="table-responsive">
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
