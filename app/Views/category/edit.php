<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Editar Categoría</h2>

<?php if (session('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<form action="<?= base_url('categories/update/'.$category['id']) ?>" method="post">
<?= csrf_field() ?>

    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="name" class="form-control" required
               value="<?= old('name', $category['name']) ?>">
    </div>
    <button class="btn btn-primary">Actualizar</button>
</form>

<?= $this->endSection() ?>
