
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Nueva Categoría</h2>
<form action="<?= base_url('categories/store') ?>" method="post">
<?= csrf_field() ?>

    <div class="mb-3">
        <label>Nombre</label>
        <!-- <input type="text" name="name" class="form-control" required> -->
        <input type="text" name="name" class="form-control" required value="<?= old('name') ?>">
    </div>
    <button class="btn btn-success">Guardar</button>
</form>

<?= $this->endSection() ?>
