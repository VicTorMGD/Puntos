<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Nuevo Usuario</h2>

<?php if (session('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<form action="<?= base_url('users/store') ?>" method="post">
<?= csrf_field() ?>

    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="name" class="form-control" required value="<?= old('name') ?>">
    </div>
    <div class="mb-3">
        <label>Correo electrónico</label>
        <input type="email" name="email" class="form-control" required value="<?= old('email') ?>">
    </div>
    <div class="mb-3">
        <label>Contraseña</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Rol</label>
        <select name="role" class="form-control" required>
            <option value="">Seleccionar rol</option>
            <option value="administrador" <?= old('role') == 'administrador' ? 'selected' : '' ?>>Administrador</option>
            <option value="vendedor" <?= old('role') == 'vendedor' ? 'selected' : '' ?>>Vendedor</option>
        </select>
    </div>

    <button class="btn btn-success">Registrar</button>
    <a href="<?= base_url('users') ?>" class="btn btn-secondary">Cancelar</a>
</form>

<?= $this->endSection() ?>
