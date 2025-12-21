<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Nuevo Producto</h2>
<?php if (session('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<form action="<?= base_url('products/store') ?>" method="post" enctype="multipart/form-data">
<?= csrf_field() ?>

    <div class="mb-3">
        <label>Nombre</label>
        
        <input type="text" name="name" class="form-control" required value="<?= old('name') ?>">
    </div>
    <div class="mb-3">
        <label>Descripción</label>
        
        <textarea name="description" class="form-control"><?= old('description') ?></textarea>
    </div>
    <div class="mb-3">
        <label>Precio</label>
        
        <input type="number" name="price" step="0.01" class="form-control" required value="<?= old('price') ?>">
    </div>
    <div class="mb-3">
        <label>Categoría</label>
        <select name="category_id" class="form-control" required>
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>" <?= old('category_id') == $c['id'] ? 'selected' : '' ?>>
                    <?= esc($c['name']) ?>
                </option>
            <?php endforeach ?>
        </select>

    </div>
    <div class="mb-3">
        <label>Imagen del producto</label>
        <input type="file" name="image" class="form-control">
    </div>
    <button class="btn btn-success">Guardar</button>
</form>

<?= $this->endSection() ?>